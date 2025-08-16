<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Customer Information
            'customer_name' => ['required', 'string', 'max:255', 'min:2'],
            'customer_email' => ['required', 'email:rfc,dns', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20', 'min:10'],
            'customer_address' => ['nullable', 'string', 'max:1000'],
            'customer_city' => ['nullable', 'string', 'max:100'],

            // Device Information
            'device_category_id' => ['required', 'exists:device_categories,id'],
            'device_type_id' => ['required', 'exists:device_types,id'],
            'device_brand' => ['nullable', 'string', 'max:100'],
            'device_model' => ['nullable', 'string', 'max:100'],
            'device_issue_description' => ['required', 'string', 'max:2000', 'min:10'],
            'device_condition' => ['nullable', 'string', 'max:1000'],

            // Repair Service
            'repair_service_id' => ['nullable', 'exists:repair_services,id'],
            'custom_repair_description' => ['nullable', 'string', 'max:1000'],

            // Appointment
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time_slot' => ['required', Rule::in(['morning', 'afternoon', 'evening', 'anytime'])],
            'preferred_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Please enter your full name.',
            'customer_name.min' => 'Name must be at least 2 characters long.',
            'customer_email.required' => 'Please enter your email address.',
            'customer_email.email' => 'Please enter a valid email address.',
            'customer_phone.required' => 'Please enter your phone number.',
            'customer_phone.min' => 'Phone number must be at least 10 digits.',

            'device_category_id.required' => 'Please select a device category.',
            'device_category_id.exists' => 'Selected device category is invalid.',
            'device_type_id.required' => 'Please select a device type.',
            'device_type_id.exists' => 'Selected device type is invalid.',
            'device_issue_description.required' => 'Please describe the issue with your device.',
            'device_issue_description.min' => 'Issue description must be at least 10 characters.',

            'repair_service_id.exists' => 'Selected repair service is invalid.',

            'preferred_date.required' => 'Please select your preferred date.',
            'preferred_date.after_or_equal' => 'Preferred date cannot be in the past.',
            'preferred_time_slot.required' => 'Please select a time slot.',
            'preferred_time_slot.in' => 'Selected time slot is invalid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'customer_name' => 'full name',
            'customer_email' => 'email address',
            'customer_phone' => 'phone number',
            'device_category_id' => 'device category',
            'device_type_id' => 'device type',
            'device_issue_description' => 'issue description',
            'repair_service_id' => 'repair service',
            'preferred_date' => 'preferred date',
            'preferred_time_slot' => 'time slot',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Custom validation: Either repair service or custom description must be provided
            if (!$this->repair_service_id && !$this->custom_repair_description) {
                $validator->errors()->add(
                    'repair_service_id',
                    'Please select a repair service or provide a custom repair description.'
                );
            }

            // Validate device type belongs to selected category
            if ($this->device_category_id && $this->device_type_id) {
                $deviceType = \App\Models\DeviceType::find($this->device_type_id);
                if ($deviceType && $deviceType->category_id != $this->device_category_id) {
                    $validator->errors()->add(
                        'device_type_id',
                        'Selected device type does not belong to the selected category.'
                    );
                }
            }

            // Validate repair service belongs to selected device type
            if ($this->device_type_id && $this->repair_service_id) {
                $repairService = \App\Models\RepairService::find($this->repair_service_id);
                if ($repairService && $repairService->device_type_id != $this->device_type_id) {
                    $validator->errors()->add(
                        'repair_service_id',
                        'Selected repair service is not available for the selected device type.'
                    );
                }
            }

            // Validate preferred time format if provided
            if ($this->preferred_time) {
                $timeSlotValidation = $this->validateTimeWithinSlot();
                if ($timeSlotValidation !== true) {
                    $validator->errors()->add('preferred_time', $timeSlotValidation);
                }
            }
        });
    }

    /**
     * Validate that preferred time falls within the selected time slot.
     */
    private function validateTimeWithinSlot(): string|bool
    {
        if (!$this->preferred_time || !$this->preferred_time_slot) {
            return true;
        }

        $time = \Carbon\Carbon::createFromFormat('H:i', $this->preferred_time);

        $timeSlots = [
            'morning' => ['09:00', '12:00'],
            'afternoon' => ['13:00', '17:00'],
            'evening' => ['18:00', '20:00'],
        ];

        if ($this->preferred_time_slot === 'anytime') {
            return true;
        }

        if (!isset($timeSlots[$this->preferred_time_slot])) {
            return true;
        }

        $startTime = \Carbon\Carbon::createFromFormat('H:i', $timeSlots[$this->preferred_time_slot][0]);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $timeSlots[$this->preferred_time_slot][1]);

        if ($time->lt($startTime) || $time->gt($endTime)) {
            $slotName = ucfirst($this->preferred_time_slot);
            $range = $timeSlots[$this->preferred_time_slot][0] . ' - ' . $timeSlots[$this->preferred_time_slot][1];
            return "The selected time does not fall within the {$slotName} time slot ({$range}).";
        }

        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Clean and format phone number
        if ($this->customer_phone) {
            $phone = preg_replace('/[^0-9+]/', '', $this->customer_phone);
            $this->merge(['customer_phone' => $phone]);
        }

        // Trim and clean text fields
        $textFields = [
            'customer_name', 'customer_email', 'customer_address', 'customer_city',
            'device_brand', 'device_model', 'device_issue_description',
            'device_condition', 'custom_repair_description'
        ];

        $cleanedData = [];
        foreach ($textFields as $field) {
            if ($this->has($field)) {
                $cleanedData[$field] = trim($this->input($field));
            }
        }

        $this->merge($cleanedData);
    }
}

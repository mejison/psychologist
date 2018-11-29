<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSupervisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supervision_id' => 'required|integer',
            'registration_date' => 'required|date',
            "supervision_type" => "required",
            "number_of_hours" => "required",
            "type_classes" => "required",
//            "udredning_intervention" => "required",
//            "type_work" => "required",
//            "comment" => "required",
            "number_of_hours" => "required",
            'group_composition'=>"",
            "supervision_type_check" => "required_if:supervision_type,default",
            "number_of_hours_check" => "required_if:number_of_hours,0",
            "group_composition_check" => "required_if:group_composition,default",

        ];
    }

    public function messages()
    {
        return [
            'supervision_id.integer' => 'Et Supervision er påkrævet',
            'registration_date.required' => 'Et Registration date er påkrævet',
            'number_of_hours.required' => 'En Number of hours er påkrævet',
            'type_classes.required' => 'En Type classes er påkrævet',
            'udredning_intervention.required' => 'Vælg Udredning eller Intervention',
            'type_work.required' => 'Vælg Ekstern eller Intern',
//            'comment.required' => 'En Comment er påkrævet',
            'supervision_type_check.required_if' => 'En Supervision type er påkrævet',
            'number_of_hours_check.required_if' => 'Time bør have mere 0',
            'group_composition_check.required_if' => 'Gruppesammensætning bør vælges fra listen',
        ];
    }
}

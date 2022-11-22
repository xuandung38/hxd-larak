<?php

namespace App\Http\Requests\Admin\Setting;

use App\Http\Requests\BaseRequest;

class UpdateSettingRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'logo' => 'required|max:255',
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'hotline' => 'required|max:255',
            'email' => 'required|max:255|email',
            'color' => 'required',
            'title' => 'required|max:255',
            'keyword' => 'required|max:255',
            'description' => 'required|max:255',
            'thumbnail' => 'required|max:255',
            'slider' => 'required|array',
        ]);
    }

    public function parameters()
    {
        $params = parent::parameters();
        if (! empty($this->input('slider'))) {
            $params['slider'] = json_encode($this->input('slider'));
        }

        return $params;
    }
}

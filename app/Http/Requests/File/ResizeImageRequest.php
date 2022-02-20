<?php

namespace App\Http\Requests\File;

use App\Http\Requests\BaseRequest;

class ResizeImageRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'files' => 'required',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
        ]);
    }

}

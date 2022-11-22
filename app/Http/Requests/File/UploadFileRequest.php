<?php

namespace App\Http\Requests\File;

use App\Enums\FileExtensions;
use App\Http\Requests\BaseRequest;

class UploadFileRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'upload' => [
                'required',
                'max:2048',
                'mimes:'.implode(',', FileExtensions::toArray()),
            ],
            'directory' => 'required',
        ]);
    }

    /**
     * Prepare parameters from Form Request.
     *
     * @return array
     */
    public function parameters()
    {
        return array_merge(parent::parameters(), [
            'upload' => $this->file('upload'),
            'directory' => $this->input('upload'),
        ]);
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'upload' => 'File',
        ];
    }
}

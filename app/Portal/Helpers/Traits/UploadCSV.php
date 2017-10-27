<?php

namespace App\Portal\Helpers\Traits;

use Illuminate\Http\Request;

/**
 * Trait UploadCSV
 *
 * This trait is used by controllers that want to allow the uploading of a CSV through that controllers index page
 *
 * @package App\Portal\Helpers\Traits
 */
trait UploadCSV
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $upload_csv_title = '';

    /**
     * Upload CSV
     *
     * Upload a CSV, loop through records and insert to the database
     *
     * @param Request $request
     * @return $this
     */
    public function uploadCSV(Request $request)
    {
        $strip_headers = $request->input('strip_headers') !== null ? true : false;

        $keys = [];

        foreach($this->fields as $field) {
            $name = $field['name'] . '_key';
            $keys[$field['name']] = $request->input($name) !== null ? $request->input($name) : null;
        }

        $file_to_upload = $_FILES['fileToUpload'];

        //use this method and ini setting to parse all CSV types (some older mac types have issues
        //with line endings).  Reset the ini after use due to issues with leaving it true
        ini_set('auto_detect_line_endings', true);
        $records = array_map("str_getcsv", file($file_to_upload['tmp_name'], FILE_SKIP_EMPTY_LINES));
        ini_set('auto_detect_line_endings', false);

        if ($strip_headers) {
            array_shift($records);
        }

        $result['success'] = false;
        $message = '';

        //Loop through and insert each record into database
        foreach ($records as $record) {
            $data = [];

            foreach($this->fields as $field) {
                $data[$field['name']] = isset($record[$keys[$field['name']]]) ? $record[$keys[$field['name']]] : '';
            }

            $result = $this->validateRequiredFields($data);

            if(!$result['success']) {
                return redirect()->back()->withInput(['response' => $result]);
            }

            $result = $this->normalizeFields($result['data']);

            if(!$result['success']) {
                return redirect()->back()->withInput(['response' => $result]);
            }

            $result = $this->insertRecord($result['data']);

            $message .= $result['message'] . '<br/>';

            if (!$result['success']) {
                break;
            }
        }

        $result['message'] = $message;

        return redirect()->back()->withInput(['response' => $result]);
    }
}
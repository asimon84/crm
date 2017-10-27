<?php

namespace App\Portal\Helpers\Traits;

use Illuminate\Http\Request;

/**
 * Trait CSVMapperFormats
 *
 * This trait is used by controllers that want to allow the Mapping of CSVs for upload purposes
 *
 * @package App\Portal\Helpers\Traits
 */
trait CSVMapperFormats
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $format_class = '';

    /**
     * Save Format
     *
     * Save a CSV Upload format for use in future uploads
     *
     * @param Request $request
     * @return $this
     */
    public function saveFormat(Request $request)
    {
        $data['format_name'] = $request->input('format_name') !== null ? $request->input('format_name') : null;
        $keys = $request->input('keys') !== null ? $request->input('keys') : null;

        for($i = 0; $i < count($this->fields); $i++ ) {
            if( isset($keys[$i]) && $keys[$i] != '' ) {
                $data[$this->fields[$i]['name'] . '_column'] = $keys[$i];
            }
        }

        $class = $this->format_class;
        $result = $class::insert($data);

        return redirect()->back()->withInput(['response' => $result]);
    }

    /**
     * Get Format
     *
     * Get a CSV Upload format by passed format ID
     *
     * @param Request $request
     * @return string
     */
    public function getFormat(Request $request) :string
    {
        $data['format_id'] = $request->input('format_id') !== null ? $request->input('format_id') : null;

        $class = $this->format_class;
        $result = $class::find($data['format_id']);

        $format = [];

        foreach($this->fields as $field) {
            $name = $field['name'] . '_column';
            $value = $result->$name;

            $format['load_'.$field['name'].'_key'] = $value;
        }

        return json_encode(
            [
                'format' => $format,
            ]
        );
    }

    /**
     * Refresh Formats
     *
     * Return a fresh list of Client Upload Formats for use after new formats are added
     *
     * @return string
     */
    public function refreshFormats() :string
    {
        $class = $this->format_class;

        return json_encode(
            [
                'formats' => $class::all(),
            ]
        );
    }
}
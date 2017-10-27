<?php

namespace App\Portal\Helpers\Traits;

use Illuminate\Http\Request;
use App\Portal\Response\Response;
use App\Portal\File\File;
use Illuminate\Support\Facades\Auth;

/**
 * Trait EditRecord
 *
 * This trait is used by controllers that want to allow the editing of a record through that controllers index page
 *
 * @package App\Portal\Helpers\Traits
 */
trait EditRecord
{
    /**
     * @var string
     */
    protected $edit_record_title = '';

    /**
     * @var array
     */
    protected $editable_fields = [];

    /**
     * @var string
     */
    protected $record_class = '';

    /**
     * @var string
     */
    protected $history_class = '';

    /**
     * @var string
     */
    protected $identifier_field = '';

    /**
     * Get Record
     *
     * Get the record details for displaying on the edit modal
     *
     * @param Request $request
     * @return string
     */
    public function getRecord(Request $request) :string
    {
        $id = ($request->input('id') !== null) ? $request->input('id') : null;

        if( is_null($id) || $id == 0 ) {
            return false;
        }

        $class = $this->record_class;
        $record = $class::find($id);

        return json_encode( $record );
    }

    /**
     * Edit Record
     *
     * Edit a single record from form input
     *
     * @param Request $request
     * @return $this
     */
    public function editRecord(Request $request)
    {
        $id = ($request->input('edit_record_id') !== null) ? $request->input('edit_record_id') : null;
        $data = [];

        foreach($this->editable_fields as $field) {
            if($field['type'] === 'file') {
                $file = $request->file($field['name']);

                if( is_null($file) ) {
                    continue;
                } else {
                    $name = $file->getClientOriginalName();

                    File::upload($file, $name);

                    $data[$field['name']] = $name;
                }
            } else {
                $data[$field['name']] = $request->input($field['name']) !== null ? $request->input($field['name']) : null;
            }
        }

        $class = $this->record_class;
        $record = $class::find($id);

        foreach($data as $key => $value) {
            $record->$key = $value;
        }

        $success = $record->save();

        $identifier_field = $this->identifier_field;

        if( $success ) {
            $class = $this->history_class;
            $class::insert(Auth::user()->id, 'updated', $id);
            $message = 'Record successfully updated: ' . $record->$identifier_field;
        } else {
            $message = 'Unable to update Record: ' . $record->$identifier_field;
        }

        $result = Response::formatResponse( $success, 200, $message, [] );

        return redirect()->back()->withInput(['response' => $result]);
    }
}
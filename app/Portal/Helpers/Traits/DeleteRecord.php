<?php

namespace App\Portal\Helpers\Traits;

use Illuminate\Http\Request;
use App\Portal\Response\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Trait DeleteRecord
 *
 * This trait is used by controllers that want to allow the deleting of a record through that controllers index page
 *
 * @package App\Portal\Helpers\Traits
 */
trait DeleteRecord
{
    /**
     * @var string
     */
    protected $delete_record_title = '';

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
     * Delete Record
     *
     * Remove a single record from form input
     *
     * @param Request $request
     * @return $this
     */
    public function deleteRecord(Request $request)
    {
        $id = $request->input('id') !== null ? $request->input('id') : null;

        $class = $this->record_class;
        $record = $class::find($id);

        $success = $record->delete();

        $identifier_field = $this->identifier_field;

        if( $success ) {
            $class = $this->history_class;
            $class::insert(Auth::user()->id, 'deleted', $record->id);
            $message = 'Record successfully deleted: ' . $record->$identifier_field;
        } else {
            $message = 'Error!  Unable to delete Record: ' . $record->$identifier_field;
        }

        $result = Response::formatResponse( $success, 200, $message, [] );

        return redirect()->back()->withInput(['response' => $result]);
    }
}
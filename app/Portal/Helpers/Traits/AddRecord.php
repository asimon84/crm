<?php

namespace App\Portal\Helpers\Traits;

use Illuminate\Http\Request;
use App\Portal\Response\Response;
use App\Portal\File\File;
use App\Portal\Clients\Clients;
use App\Portal\Products\Products;
use App\Portal\Products\ProductTypes;
use App\Portal\Alerts\AlertsSources;
use App\Portal\MIDs\MIDs;
use App\Portal\CreditCards\CardAssociations;
use App\Portal\Currencies\Currencies;
use App\Portal\ReasonCodes\ReasonCodes;
use Illuminate\Support\Facades\Auth;

/**
 * Trait AddRecord
 *
 * This trait is used by controllers that want to allow the adding of a record through that controllers index page
 *
 * @package App\Portal\Helpers\Traits
 */
trait AddRecord
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $add_record_title = '';

    /**
     * @var string
     */
    protected $record_class = '';

    /**
     * @var string
     */
    protected $field_class = '';

    /**
     * @var string
     */
    protected $history_class = '';

    /**
     * @var string
     */
    protected $identifier_field = '';

    /**
     * Add Record
     *
     * Add a single record from form input
     *
     * @param Request $request
     * @return $this
     */
    public function addRecord(Request $request)
    {
        $result = $this->processRequest($request);

        if($result['success']) {
            $result = $this->validateRequiredFields($result['data']);

            if($result['success']) {
                $result = $this->normalizeFields($result['data']);

                if($result['success']) {
                    $result = $this->insertRecord($result['data']);
                }
            }
        }

        return redirect()->back()->withInput(['response' => $result]);
    }

    /**
     * Process Request
     *
     * Process request inputs, upload any file inputs along the way
     *
     * @param Request $request
     * @return array
     */
    public function processRequest(Request $request) :array
    {
        $success = true;
        $message = '';
        $data = [];

        foreach($this->fields as $field) {
            if($field['type'] === 'file') {
                $file = $request->file($field['name']);

                if( is_null($file) ) {
                    $message = 'Error adding record!  Failed to upload file: ' . $field['name'];
                    $success = false;
                    break;
                }

                $name = $file->getClientOriginalName();

                File::upload($file, $name);

                $data[$field['name']] = $name;
            } else {
                $data[$field['name']] = $request->input($field['name']) !== null ? $request->input($field['name']) : null;
            }
        }

        return Response::formatResponse($success, 200, $message, $data);
    }

    /**
     * Validate Required Fields
     *
     * Make sure all required fields exist and add all fields to the data array
     *
     * @param array $data
     * @return array
     */
    public function validateRequiredFields(array $data) :array
    {
        $success = true;
        $message = '';
        $record = [];

        $class = $this->field_class;

        foreach ($class::getFields() as $field) {
            if($field['required'] && (!isset($data[$field['name']]) || empty($data[$field['name']]))) {
                $message = 'Missing Required Field to Add Record: ' . $field['label'];
                $success = false;
                break;
            }

            if(isset($data[$field['name']]) && !empty($data[$field['name']])) {
                if($field['type'] == 'date') {
                    $record[$field['name']] = ( new \DateTime($data[$field['name']]))->format('Y-m-d');
                } else {
                    $record[$field['name']] = $data[$field['name']];
                }
            }
        }

        return Response::formatResponse($success, 200, $message, $record);
    }

    /**
     * Normalize Fields
     *
     * For records that require numeric IDs, switch them to numeric if necessary
     *
     * @param array $data
     * @return array
     */
    public function normalizeFields(array $data) :array
    {
        $success = true;
        $message = '';

        while(true) {
            if ( isset($data['client_id']) && !is_numeric($data['client_id']) ) {
                $result = Clients::where('name', '=', $data['client_id'])->get()->toArray();

                if (empty($result)) {
                    $message = 'Failed to Add Record: No Match Found For Client \'' . $data['client_id'] . '\'';
                    $success = false;
                    break;
                } else {
                    $data['client_id'] = $result[0]['id'];
                }
            }

            if( isset($data['product_id']) && !is_numeric( $data['product_id'] ) ) {
                $product_name = $data['product_id'];
                $result = Products::where([['name', '=', $product_name],['client_id','=',$data['client_id']]])->get()->toArray();

                if( empty($result)) {
                    $message = 'Failed to Add Order: No Match Found For Product \'' . $data['product_id'] . '\'';
                    $success = false;
                    break;
                } else {
                    $data['product_id'] = $result[0]['id'];
                }
            }

            if( isset($data['product_type_id']) && !is_numeric( $data['product_type_id'] ) ) {
                $product_name = ucwords( strtolower( $data['product_type_id'] ) );
                $result = ProductTypes::where('name', '=', $product_name)->get()->toArray();

                if( empty($result)) {
                    $message = 'Failed to Add Product: No Match Found For Product Type \'' . $data['product_type_id'] . '\'';
                    $success = false;
                    break;
                } else {
                    $data['product_type_id'] = $result[0]['id'];
                }
            }

            if( isset($data['source_id']) && !is_numeric( $data['source_id'] ) ) {
                $result = AlertsSources::where('name', '=', $data['source_id'])->get()->toArray();

                if( empty($result)) {
                    $message = 'Failed to Add Record: No Match Found For Alert Source \'' . $data['source_id'] . '\'';
                    $success = false;
                    break;
                } else {
                    $data['source_id'] = $result[0]['id'];
                }
            }

            if( isset($data['mid_id']) && !is_numeric( $data['mid_id'] ) ) {
                $result = MIDs::where('name', '=', $data['mid_id'])->get()->toArray();

                if( empty($result)) {
                    $message = 'Failed to Add Record: No Match Found For MID \'' . $data['mid_id'] . '\'';
                    $success = false;
                    break;
                } else {
                    $data['mid_id'] = $result[0]['id'];
                }
            }

            if( isset($data['card_association_id']) && !is_numeric( $data['card_association_id'] ) ) {
                $card_type = ucwords( strtolower( $data['card_association_id'] ) );
                $result = CardAssociations::where('name', '=', $card_type)->get()->toArray();

                if( empty($result)) {
                    $message = 'Failed to Add Record: No Match Found For Card Type \'' . $data['card_association_id'] . '\'';
                    $success = false;
                    break;
                } else {
                    $data['card_association_id'] = $result[0]['id'];
                }
            }

            if( isset($data['currency_id']) && !is_numeric( $data['currency_id'] ) ) {
                $currency_id = strtoupper( $data['currency_id'] );
                $result = Currencies::where('code', '=', $currency_id)->get()->toArray();

                if( empty($result)) {
                    $currency_id = ucwords( strtolower( $data['currency_id'] ) );
                    $result = Currencies::where('name', '=', $currency_id)->get()->toArray();

                    if( empty($result)) {
                        $message = 'Failed to Add Record: No Match Found For Currency \'' . $data['currency_id'] . '\'';
                        $success = false;
                        break;
                    }
                }

                $data['currency_id'] = $result[0]['id'];
            }

            if( isset($data['reason_code_id']) && !is_numeric( $data['reason_code_id'] ) ) {
                $reason_code_id = ucwords( strtolower( $data['reason_code_id'] ) );
                $result = ReasonCodes::where('name', '=', $reason_code_id)->get()->toArray();

                if( empty($result)) {
                    $message = 'Failed to Add Record: No Match Found For Reason Code \'' . $data['reason_code_id'] . '\'';
                    $success = false;
                    break;
                } else {
                    $data['reason_code_id'] = $result[0]['id'];
                }
            }

            break;
        }

        return Response::formatResponse($success, 200, $message, $data);
    }

    /**
     * Insert Record
     *
     * Insert the record into the database
     *
     * @param array $data
     * @return array
     */
    public function insertRecord(array $data) :array
    {
        $class = $this->record_class;
        $record = (new $class());

        foreach($data as $key => $value) {
            $record->$key = $value;
        }

        $success = $record->save();

        $identifier_field = $this->identifier_field;

        if( $success ) {
            $class= $this->history_class;
            $class::insert(Auth::user()->id, 'added', $record->id);
            $message = 'Record successfully added: ' . $record->$identifier_field;
        } else {
            $message = 'Unable to add Record: ' . $record->$identifier_field;
        }

        return Response::formatResponse($success, 200, $message, [$record]);
    }
}
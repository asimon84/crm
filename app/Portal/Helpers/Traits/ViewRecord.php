<?php

namespace App\Portal\Helpers\Traits;

use App\Portal\CreditCards\CardAssociations;
use App\User;
use App\Portal\Clients\Clients;
use App\Portal\MIDs\MIDs;
use App\Portal\Products\Products;
use App\Portal\Products\ProductTypes;
use Illuminate\Http\Request;

/**
 * Trait ViewRecord
 *
 * This trait is used by controllers that want to allow the viewing of a record through that controllers index page
 *
 * @package App\Portal\Helpers\Traits
 */
trait ViewRecord
{
    /**
     * @var string
     */
    protected $view_record_title = '';

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
    protected $history_id = '';

    /**
     * View Record
     *
     * View a single record and format it for the view modal
     *
     * @param Request $request
     * @return string
     */
    public function viewRecord(Request $request) :string
    {
        $id = ($request->input('id') !== null) ? $request->input('id') : null;

        if( is_null($id) || $id == 0 ) {
            return false;
        }

        $class = $this->record_class;
        $record = $class::find($id);

        $output = '<div id="details_content" class="tab-pane active">';

        if (!empty($record)) {
            foreach ($this->fields as $field) {
                $name = $field['name'];

                if($name == 'client_id') {
                    $client = Clients::find($record->$name);

                    $output .= '<div class="row">
                        <div class="modal_entry">
                            <label class="col-md-4 text-right">' . $field['label'] . ': </label>
                            <div class="col-md-8">
                                ' . $client->name . '
                            </div>
                        </div>
                    </div>';
                } else if($name == 'product_id') {
                    $product = Products::find($record->$name);

                    $output .= '<div class="row">
                        <div class="modal_entry">
                            <label class="col-md-4 text-right">' . $field['label'] . ': </label>
                            <div class="col-md-8">
                                ' . $product->name . '
                            </div>
                        </div>
                    </div>';
                } else if($name == 'product_type_id') {
                    $product_type = ProductTypes::find($record->$name);

                    $output .= '<div class="row">
                        <div class="modal_entry">
                            <label class="col-md-4 text-right">' . $field['label'] . ': </label>
                            <div class="col-md-8">
                                ' . $product_type->name . '
                            </div>
                        </div>
                    </div>';
                } else if($name == 'mid_id') {
                    $mid = MIDs::find($record->$name);

                    $output .= '<div class="row">
                        <div class="modal_entry">
                            <label class="col-md-4 text-right">' . $field['label'] . ': </label>
                            <div class="col-md-8">
                                ' . $mid->mid . '
                            </div>
                        </div>
                    </div>';
                } else if($name == 'card_association_id') {
                    $card_association = CardAssociations::find($record->$name);

                    $output .= '<div class="row">
                        <div class="modal_entry">
                            <label class="col-md-4 text-right">' . $field['label'] . ': </label>
                            <div class="col-md-8">
                                ' . $card_association->name . '
                            </div>
                        </div>
                    </div>';
                } else if($field['type'] == 'html') {
                    $output .= '<div class="row">
                        <div class="modal_entry">
                            <label class="col-md-4 text-right">' . $field['label'] . ': </label>
                            <div class="col-md-8">
                                <textarea style="display:none;" id="' . $field['name'] . '" name="' . $field['name'] . '">' . $record->$name . '</textarea>
                                <button class="btn btn-info" id="view_html_button" data-field="' . $field['name'] . '"><i class="fa fa-file-o"></i></button>
                            </div>
                        </div>
                    </div>';
                } else {
                    $output .= '<div class="row">
                        <div class="modal_entry">
                            <label class="col-md-4 text-right">' . $field['label'] . ': </label>
                            <div class="col-md-8">
                                ' . $record->$name . '
                            </div>
                        </div>
                    </div>';
                }
            }
        }

        $output .= '</div>';

        $class = $this->history_class;
        $history = $class::where($this->history_id, '=', $id)->get();

        $output .= '<div id="history_content" class="tab-pane">';

        if (!empty($history)) {
            foreach ($history as $entry) {
                $user = User::find($entry->user_id);

                $output .= '<div class="row">
                    <div class="modal_entry">
                       <label class="col-md-4 text-right">User - ' . $user->name . ' (' . $user->id . '): </label>
                       <div class="col-md-8">
                            ' . ucwords($entry->action) . ' - ' . (new \DateTime($entry->created_at))->format('Y-m-d') . '
                       </div>
                    </div>
                </div>';
            }
        }

        $output .= '</div>';

        return $output;
    }
}
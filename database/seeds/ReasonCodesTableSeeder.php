<?php

use Illuminate\Database\Seeder;

class ReasonCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //VISA Chargeback Reason Codes
        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '30',
            'description' => 'Services Not Provided or Merchandise Not Received',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '41',
            'description' => 'Cancelled Recurring Transaction',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '53',
            'description' => 'Not as Described or Defective Merchandise',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '57',
            'description' => 'Fraudulent Multiple Transactions',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '60',
            'description' => 'Illegible Fulfillment',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '62',
            'description' => 'Counterfeit Transactions',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '70',
            'description' => 'Card Recovery Bulletin or Exception File',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '71',
            'description' => 'Declined Authorisation',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '73',
            'description' => 'Expired Card',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '74',
            'description' => 'Late Presentment',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '75',
            'description' => 'Transaction Not Recognised',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '76',
            'description' => 'Incorrect Currency or Transaction Code or Domestic Transaction Processing Violation',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '77',
            'description' => 'Non Matching Account Number',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '78',
            'description' => 'Service Code Violation',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '80',
            'description' => 'Incorrect Transaction Amount or Account Number',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '81',
            'description' => 'Fraud - Card Present Environment',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '82',
            'description' => 'Duplicate Processing',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '83',
            'description' => 'Fraud - Card Absent Environment',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '85',
            'description' => 'Credit Not Processed',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '86',
            'description' => 'Paid By Other Means',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '90',
            'description' => 'Non Receipt of Cash or Load Transaction at ATM or Load Device',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '93',
            'description' => 'Risk Identification Service',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 1,
            'code' => '96',
            'description' => 'Transaction Exceeds Terminal Amount',
        ]);



        //MasterCard Chargeback Reason Codes
        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4802',
            'description' => 'Requested/Required Information Illegible or Missing',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4807',
            'description' => 'Warning Bulletin File',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4808',
            'description' => 'Requested/Required Authorisation Not Obtained',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4812',
            'description' => 'Account Number Not On File',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4831',
            'description' => 'Transaction Amount Differs',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4834',
            'description' => 'Duplicate Processing',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4835',
            'description' => 'Card Not Valid or Expired',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4837',
            'description' => 'No Cardholder Authorisation',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4840',
            'description' => 'Fraudulent Processing of Transactions',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4841',
            'description' => 'Cancelled Recurring Transaction',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4842',
            'description' => 'Late Presentment',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4846',
            'description' => 'Correct Transaction Currency Code Not Provided',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4847',
            'description' => 'Exceeds Floor Limit, Not Authorised, and Fraudulent Transaction',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4849',
            'description' => 'Questionable Merchant Activity',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4850',
            'description' => 'Credit Posted as a Purchase',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4853',
            'description' => 'Cardholder Dispute, Defective / Not as Described',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4855',
            'description' => 'Non-receipt of Merchandise',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4857',
            'description' => 'Card-Activated Telephone Transaction',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4859',
            'description' => 'Services Not Rendered',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4860',
            'description' => 'Credit Not Processed',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4862',
            'description' => 'Counterfeit Transaction Magnetic Stripe POS Fraud',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 2,
            'code' => '4863',
            'description' => 'Cardholder Does Not Recognise-Potential Fraud',
        ]);



        //Amex Chargeback Reason Codes
        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'F10',
            'description' => 'Missing Imprint',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'F14',
            'description' => 'Missing Signature',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'F24',
            'description' => 'No Card Member Authorization',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'F29',
            'description' => 'Card Not Present',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'F30',
            'description' => 'EMV Counterfeit',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'F31',
            'description' => 'EMV Lost/Stolen/Non-Received',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'A01',
            'description' => 'Charge Amount Exceeds Authorization Amount',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'A02',
            'description' => 'No Valid Authorization',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'A08',
            'description' => 'Authorization Approval Expired',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'P01',
            'description' => 'Unassigned Card Number',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'P03',
            'description' => 'Credit Processed as Charge',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'P04',
            'description' => 'Charge Processed as Credit',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'P05',
            'description' => 'Incorrect Charge Amount',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'P07',
            'description' => 'Late Submission',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'P08',
            'description' => 'Duplicate Charge',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'P22',
            'description' => 'Non-Matching Card Number',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'P23',
            'description' => 'Currency Discrepancy',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C02',
            'description' => 'Credit Not Processed',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C04',
            'description' => 'Goods/Services Returned or Refused',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C05',
            'description' => 'Goods/Services Canceled',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C08',
            'description' => 'Goods/Services Not Received or Only Partially Received',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C14',
            'description' => 'Paid by Other Means',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C18',
            'description' => 'No Show or CARDeposit Canceled',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C28',
            'description' => 'Canceled Recurring Billing',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C31',
            'description' => 'Goods/Services Not As Described',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'C32',
            'description' => 'Goods/Services Damaged or Defective',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'M10',
            'description' => 'Vehicle Rental – Capital Damages',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'M49',
            'description' => 'Vehicle Rental – Theft or Loss of Use',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'M01',
            'description' => 'Chargeback Authorization',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'R03',
            'description' => 'Insufficient Reply',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'R13',
            'description' => 'No Reply',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'FR2',
            'description' => 'Fraud Full Recourse Program',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'FR4',
            'description' => 'Immediate Chargeback Program',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 3,
            'code' => 'FR6',
            'description' => 'Partial Immediate Chargeback Program',
        ]);



        //Discover Chargeback Reason Codes
        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'UA01',
            'description' => 'Fraud – Card Present Transaction',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'UA02',
            'description' => 'Fraud – Card Not Present Transaction',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'UA05',
            'description' => 'Fraud – Chip Counterfeit Transaction',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'UA06',
            'description' => 'Fraud – Chip and PIN Transaction',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'AT',
            'description' => 'Authorization Noncompliance',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'IN',
            'description' => 'Invalid Card Number',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'LP',
            'description' => 'Late Presentation',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => '05',
            'description' => 'Good Faith Investigation',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'AA',
            'description' => 'Does Not Recognize',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'AP',
            'description' => 'Recurring Payments',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'AW',
            'description' => 'Altered Amount',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'CD',
            'description' => 'Credit/Debit Posted Incorrectly',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'DP',
            'description' => 'Duplicate Processing',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'NF',
            'description' => 'Non-Receipt of Cash from ATM',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'PM',
            'description' => 'Paid by Other Means',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'RG',
            'description' => 'Non-Receipt of Goods, Services, or Cash',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'RM',
            'description' => 'Cardholder Disputes Quality of Goods or Services',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'RN2',
            'description' => 'Credit Not Processed',
        ]);

        DB::table('reason_codes')->insert([
            'card_association_id' => 4,
            'code' => 'DC',
            'description' => 'Dispute Compliance',
        ]);
    }
}

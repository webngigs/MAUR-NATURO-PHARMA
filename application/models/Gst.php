<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gst extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->load->library('lcustomer');
		$this->load->library('session');
		$this->load->model('Customers');
		$this->load->model('Web_settings');
		$this->auth->check_admin_auth();
	}

	public function getList(){

		$admin_information	=	$this->db->select('state_code')->from('users')->where('user_id', 1)->get()->result_array();
		$admin_state_code	=	$admin_information[0]['state_code'];
		
		echo $fromdate = $this->input->post('from_date');
		echo $todate   = $this->input->post('to_date');	

		$datbetween = "";
		if(!empty($fromdate))	$datbetween = "(i.date BETWEEN '$fromdate' AND '$todate')";

		$this->db->select('i.*, id.*, ci.*, 
			pi.product_id, pi.product_name, pi.box_size, pi.tax0, pi.HSNcode, pi.product_details, pi.product_model, pi.item_rate, pi.price,
			(SELECT expeire_date FROM product_purchase_details WHERE product_purchase_details.product_id = pi.product_id LIMIT 1) AS expeire_date'
		);

		$this->db->from('invoice AS i');
		$this->db->where('i.type_of_invoice', 1);
		if(!empty($fromdate) && !empty($todate))	$this->db->where($datbetween);

		$this->db->join('invoice_details AS id', 'id.invoice_id = i.invoice_id', 'LEFT');
		$this->db->join('customer_information AS ci', 'i.customer_id = ci.customer_id', 'LEFT');
		$this->db->join('product_information AS pi', 'pi.product_id = id.product_id', 'LEFT');

		$query = $this->db->get();
		$collection = array();
		
		$collection[0]['GSTINOfSupplier']		=	'GSTIN of Supplier';
		$collection[0]['TradeLegalName']		=	'Trade Legal Name';
		$collection[0]['InvoiceNumber']			=	'Invoice Number';
		$collection[0]['InvoiceType']			=	'Invoice Type';
		$collection[0]['InvoiceDate']			=	'Invoice Date';
		$collection[0]['InvoiceValue']			=	'Invoice Value (₹)';
		$collection[0]['PlaceOfSupply']			=	'Place Of Supply';
		$collection[0]['ReferenceDate']			=	'Reference Date';
		$collection[0]['Rate']					=	'Rate (%)';
		$collection[0]['TaxableValue']			=	'Taxable Value (₹)';
		$collection[0]['IntegratedTax']			=	'Integrated Tax (₹)';
		$collection[0]['CentralTax']			=	'Central Tax (₹)';
		$collection[0]['StateUTTax']			=	'State/UT Tax (₹)';
		$collection[0]['Cess']					=	'Cess (₹)';
		$collection[0]['ROUNDOFF']				=	'ROUND OFF';
		$collection[0]['GSTR15FilingDate']		=	'GSTR-1/5 Filing Date';
		$collection[0]['ITCAvailability']		=	'ITC Availability';
		$collection[0]['Reason']				=	'Reason';
		$collection[0]['ApplicableTaxRate']		=	'Applicable % Tax Rate';
		$collection[0]['PartyStateName']		=	'Party State Name';
		$collection[0]['InvoiceNumbers']			=	'Invoice Number';
		$collection[0]['PurchaseAccounts']		=	'Purchase Accounts';
		$collection[0]['IGST']					=	'IGST';
		$collection[0]['CGST']					=	'CGST';
		$collection[0]['SGST']					=	'SGST';
		$collection[0]['CESS']					=	'CESS';
		$collection[0]['InvoiceNumberss']		=	'Invoice Number';
		$collection[0]['Blank']					=	'';
		$collection[0]['TaxableLedger']			=	'Taxable Ledger';
		$collection[0]['IGSTLedgers']			=	'IGST Ledgers';
		$collection[0]['CGSTLedgers']			=	'CGST Ledgers';
		$collection[0]['SGSTLedgers']			=	'SGST Ledgers';
		$collection[0]['CESSLedgers']			=	'CESS Ledgers';
		$collection[0]['ItemName']				=	'Item Name';
		$collection[0]['HSN']					=	'HSN';
		$collection[0]['BatchId']				=	'Batch Id';
		$collection[0]['Expiry']				=	'Expiry';
		$collection[0]['MRP']					=	'MRP';
		$collection[0]['DISC']					=	'DISC';
		$collection[0]['RATE']					=	'RATE';
		$collection[0]['Qty']					=	'Qty';
		$collection[0]['TotalProductCost']		=	'Total Product Cost';
		$collection[0]['TotalBillAmount']		=	'Total Bill Amount';

		if($query->num_rows()>0){
			$records =  $query->result_array();			
			$i = 1;
			foreach($records as $record){
				$customer_state_code = $record['state_code'];
				$IGST = ''; $CGST = ''; $SGST = ''; $IntegratedTax = ''; $CentralTax = ''; $StateUTTax = '';
				$IGSTLedgers = ''; $CGSTLedgers = ''; $SGSTLedgers = '';

				$TaxableLedger = '';

				$tax = $record['tax0'];
				if($customer_state_code == $admin_state_code){
					$IGST = ''; $CGST = ($tax/2); $SGST = ($tax/2);
					
					$gstAmount = (($record['total_price'] * $tax)/100);
					$IntegratedTax = ''; $CentralTax = ($gstAmount/2); $StateUTTax = ($gstAmount/2);
					
					$IGSTLedgers = ''; $CGSTLedgers = 'CGST '.$CGST.'%'; $SGSTLedgers = 'SGST '.$CGST.'%';
					$TaxableLedger = 'Purchase '.$tax.'%';
					if($tax<=0 || empty($tax))	{
						$TaxableLedger = 'Purchase Exempt';
						$IGST = ''; 
						$CGST = ''; 
						$SGST = '';
						$IGSTLedgers = ''; $
						$CGSTLedgers = '';
						$SGSTLedgers = '';

						$CentralTax = ''; 
						$StateUTTax = '';
						$IntegratedTax = '';
					}
				}
				else{
					$IGST = $tax; $CGST = ''; $SGST = '';

					$gstAmount = (($record['total_price'] * $tax)/100);
					$IntegratedTax = $gstAmount;	$CentralTax = ''; $StateUTTax = '';

					$IGSTLedgers = 'IGST '.$IGST.'%'; $CGSTLedgers = ''; $SGSTLedgers = '';
					$TaxableLedger = 'Purchase Exempt';

					if($tax<=0 || empty($tax))	{
						$IGSTLedgers = '';	
						$IGST = '';
						$IntegratedTax = '';
						$CentralTax = ''; 
						$StateUTTax = '';
					}
				}

				if($IGST<=0 || empty($IGST))	$IGST = '';
				if($CGST<=0 || empty($CGST))	$CGST = '';
				if($SGST<=0 || empty($SGST))	$SGST = '';

				if($IntegratedTax<=0 || empty($IntegratedTax))	$IntegratedTax 	= '';
				if($CentralTax<=0 || empty($CentralTax))		$CentralTax 	= '';
				if($StateUTTax<=0 || empty($StateUTTax))		$StateUTTax 	= '';


				if($tax<=0 || empty($tax))	$tax = '';
				if($record['total_tax']<=0)	$record['total_tax'] = '';

				$collection[$i]['GSTINOfSupplier']		=	$record['gst_no'];
				$collection[$i]['TradeLegalName']		=	$record['customer_name'];
				$collection[$i]['InvoiceNumber']		=	$record['invoice'];
				$collection[$i]['InvoiceType']			=	'Regular';
				$collection[$i]['InvoiceDate']			=	$record['date'];
				$collection[$i]['InvoiceValue']			=	$record['total_amount'];
				$collection[$i]['PlaceOfSupply']		=	$record['state'];
				$collection[$i]['ReferenceDate']		=	$record['date'];
				$collection[$i]['Rate']					=	$tax;
				$collection[$i]['TaxableValue']			=	$record['total_tax'];
				$collection[$i]['IntegratedTax']		=	$IntegratedTax;
				$collection[$i]['CentralTax']			=	$CentralTax;
				$collection[$i]['StateUTTax']			=	$StateUTTax;
				$collection[$i]['Cess']					=	'0';
				$collection[$i]['ROUNDOFF']				=	'';
				$collection[$i]['GSTR15FilingDate']		=	'';
				$collection[$i]['ITCAvailability']		=	'Yes';
				$collection[$i]['Reason']				=	'';
				$collection[$i]['ApplicableTaxRate']	=	$tax;
				$collection[$i]['PartyStateName']		=	$record['state'];
				$collection[$i]['InvoiceNumbers']		=	$record['invoice'];
				$collection[$i]['PurchaseAccounts']		=	'';
				$collection[$i]['IGST']					=	$IGST;
				$collection[$i]['CGST']					=	$CGST;
				$collection[$i]['SGST']					=	$SGST;
				$collection[$i]['CESS']					=	'';
				$collection[$i]['InvoiceNumberss']		=	$record['invoice'];
				$collection[$i]['Blank']					=	'';
				$collection[$i]['TaxableLedger']		=	$TaxableLedger;
				$collection[$i]['IGSTLedgers']			=	$IGSTLedgers;
				$collection[$i]['CGSTLedgers']			=	$CGSTLedgers;
				$collection[$i]['SGSTLedgers']			=	$SGSTLedgers;
				$collection[$i]['CESSLedgers']			=	'';
				$collection[$i]['ItemName']				=	$record['product_name'];
				$collection[$i]['HSN']					=	$record['HSNcode'];
				$collection[$i]['BatchId']				=	$record['batch_id'];
				$collection[$i]['Expiry']				=	$record['expeire_date'];
				$collection[$i]['MRP']					=	$record['price'];
				$collection[$i]['DISC']					=	$record['discount'];
				$collection[$i]['RATE']					=	$record['item_rate'];
				$collection[$i]['Qty']					=	$record['quantity'];
				$collection[$i]['TotalProductCost']		=	$record['price'] * $record['quantity'];
				$collection[$i]['TotalBillAmount']		=	$record['total_price'];
				$i++;
			}
		}

		$filename = 'GSTRII-'.date('Ymd').'-'.date('His');
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"$filename".".csv\"");
		header("Pragma: no-cache");
		header("Expires: 0");
		$handle = fopen('php://output', 'w');

		foreach($collection as $data_array) {
			fputcsv($handle, $data_array);
		}
		fclose($handle);
	}
}
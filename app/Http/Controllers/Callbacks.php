<?php

namespace App\Http\Controllers;

use App\Jobs\SaveTransaction;
use Illuminate\Http\Request;

class Callbacks
    {
        public function processB2BRequestCallback(Request $request)
            {
                $callbackData 							=	$request->Result;
                $resultCode 							=	$callbackData->ResultCode;
                $resultDesc 							=	$callbackData->ResultDesc;
                $originatorConversationID 				=	$callbackData->OriginatorConversationID;
                $conversationID 						=	$callbackData->ConversationID;
                $transactionID 							=	$callbackData->TransactionID;
                $transactionReceipt						=	$callbackData->ResultParameters->ResultParameter[0]->Value;
                $transactionAmount						=	$callbackData->ResultParameters->ResultParameter[1]->Value;
                $b2CWorkingAccountAvailableFunds		=	$callbackData->ResultParameters->ResultParameter[2]->Value;
                $b2CUtilityAccountAvailableFunds		=	$callbackData->ResultParameters->ResultParameter[3]->Value;
                $transactionCompletedDateTime			=	$callbackData->ResultParameters->ResultParameter[4]->Value;
                $receiverPartyPublicName				=	$callbackData->ResultParameters->ResultParameter[5]->Value;
                $B2CChargesPaidAccountAvailableFunds	=	$callbackData->ResultParameters->ResultParameter[6]->Value;
                $B2CRecipientIsRegisteredCustomer		=	$callbackData->ResultParameters->ResultParameter[7]->Value;

                $result=array(
                                    "resultCode"							=>	$resultCode,
                                    "resultDesc"							=>	$resultDesc,
                                    "originatorConversationID"				=>	$originatorConversationID,
                                    "conversationID"						=>	$conversationID,
                                    "transactionID"							=>	$transactionID,
                                    "transactionReceipt"					=>	$transactionReceipt,
                                    "transactionAmount"						=>	$transactionAmount,
                                    "b2CWorkingAccountAvailableFunds"		=>	$b2CWorkingAccountAvailableFunds,
                                    "b2CUtilityAccountAvailableFunds"		=>	$b2CUtilityAccountAvailableFunds,
                                    "transactionCompletedDateTime"			=>	$transactionCompletedDateTime,
                                    "receiverPartyPublicName"				=>	$receiverPartyPublicName,
                                    "B2CChargesPaidAccountAvailableFunds"	=>	$B2CChargesPaidAccountAvailableFunds,
                                    "B2CRecipientIsRegisteredCustomer"		=>	$B2CRecipientIsRegisteredCustomer
                                );


            }
        public function processB2CRequestCallback(Request $request)
            {
                $callbackData 						= 	$request->Result;
                $resultCode 						=  	$callbackData->ResultCode;
                $resultDesc 						=	$callbackData->ResultDesc;
                $originatorConversationID 			= 	$callbackData->OriginatorConversationID;
                $conversationID 					=	$callbackData->ConversationID;
                $transactionID 						=	$callbackData->TransactionID;
                $initiatorAccountCurrentBalance 	= 	$callbackData->ResultParameters->ResultParameter[0]->Value;
                $debitAccountCurrentBalance 		=	$callbackData->ResultParameters->ResultParameter[1]->Value;
                $amount 							=	$callbackData->ResultParameters->ResultParameter[2]->Value;
                $debitPartyAffectedAccountBalance	=	$callbackData->ResultParameters->ResultParameter[3]->Value;
                $transCompletedTime 				=	$callbackData->ResultParameters->ResultParameter[4]->Value;
                $debitPartyCharges 					= 	$callbackData->ResultParameters->ResultParameter[5]->Value;
                $receiverPartyPublicName 			= 	$callbackData->ResultParameters->ResultParameter[6]->Value;
                $currency							=	$callbackData->ResultParameters->ResultParameter[7]->Value;

                $result                             =   array(
                                                                "resultCode"						=>	$resultCode,
                                                                "resultDesc"						=>	$resultDesc,
                                                                "originatorConversationID"			=>	$originatorConversationID,
                                                                "conversationID"					=>	$conversationID,
                                                                "transactionID"						=>	$transactionID,
                                                                "initiatorAccountCurrentBalance"	=>	$initiatorAccountCurrentBalance,
                                                                "debitAccountCurrentBalance"		=>	$debitAccountCurrentBalance,
                                                                "amount"							=>	$amount,
                                                                "debitPartyAffectedAccountBalance"	=>	$debitPartyAffectedAccountBalance,
                                                                "transCompletedTime"				=>	$transCompletedTime,
                                                                "debitPartyCharges"					=>	$debitPartyCharges,
                                                                "receiverPartyPublicName"			=>	$receiverPartyPublicName,
                                                                "currency"							=>	$currency
                                                            );



            }
        public function C2BRequestValidation(Request $request)
            {


                $callbackData 		=	$request;

                $transactionType 	=	$callbackData->TransactionType;
                $transID 			=	$callbackData->TransID;
                $transTime 			=	$callbackData->TransTime;
                $transAmount 		=	$callbackData->TransAmount;
                $businessShortCode 	=	$callbackData->BusinessShortCode;
                $billRefNumber 		=	$callbackData->BillRefNumber;
                $invoiceNumber 		=	$callbackData->InvoiceNumber;
                $orgAccountBalance 	= 	$callbackData->OrgAccountBalance;
                $thirdPartyTransID 	=	$callbackData->ThirdPartyTransID;
                $MSISDN 			=	$callbackData->MSISDN;
                $firstName 			=	$callbackData->FirstName;
                $middleName 		=	$callbackData->MiddleName;
                $lastName 			=	$callbackData->LastName;

                $result             =   array(
                                                "transTime"			=>	$transTime,
                                                "transAmount"		=>	$transAmount,
                                                "businessShortCode"	=>	$businessShortCode,
                                                "billRefNumber"		=>	$billRefNumber,
                                                "invoiceNumber"		=>	$invoiceNumber,
                                                "orgAccountBalance"	=>	$orgAccountBalance,
                                                "thirdPartyTransID"	=>	$thirdPartyTransID,
                                                "MSISDN"			=>	$MSISDN,
                                                "firstName"			=>	$firstName,
                                                "lastName"			=>	$lastName,
                                                "middleName"		=>	$middleName,
                                                "transID"			=>	$transID,
                                                "transactionType"	=>	$transactionType
                                            );




            }
        public function processC2BRequestConfirmation(Request $request)
            {
                $callbackData 		=	$request;
                $transactionType 	=	$callbackData->TransactionType;
                $transID 			= 	$callbackData->TransID;
                $transTime 			=	$callbackData->TransTime;
                $transAmount 		=	$callbackData->TransAmount;
                $businessShortCode 	=	$callbackData->BusinessShortCode;
                $billRefNumber 		=	$callbackData->BillRefNumber;
                $invoiceNumber 		=	$callbackData->InvoiceNumber;
                $orgAccountBalance 	=	$callbackData->OrgAccountBalance;
                $thirdPartyTransID 	=	$callbackData->ThirdPartyTransID;
                $MSISDN 			=	$callbackData->MSISDN;
                $firstName 			=	$callbackData->FirstName;
                $middleName 		= 	$callbackData->MiddleName;
                $lastName 			=	$callbackData->LastName;


                $result             =   array(
                                                    "transTime"			=>	$transTime,
                                                    "transAmount"		=>	$transAmount,
                                                    "businessShortCode"	=>	$businessShortCode,
                                                    "billRefNumber"		=>	$billRefNumber,
                                                    "invoiceNumber"		=>	$invoiceNumber,
                                                    "orgAccountBalance"	=>	$orgAccountBalance,
                                                    "thirdPartyTransID"	=>	$thirdPartyTransID,
                                                    "MSISDN"			=>	$MSISDN,
                                                    "firstName"			=>	$firstName,
                                                    "lastName"			=>	$lastName,
                                                    "middleName"		=>	$middleName,
                                                    "transID"			=>	$transID,
                                                    "transactionType"	=>	$transactionType
                                            );
                SaveTransaction::dispatch($result);

            }
        public function processAccountBalanceRequestCallback(Request $request)
            {

                $callbackData               =   $request->Result;
                $resultType                 =   $callbackData->ResultType;
                $resultCode                 =   $callbackData->ResultCode;
                $resultDesc                 =   $callbackData->ResultDesc;
                $originatorConversationID   =   $callbackData->OriginatorConversationID;
                $conversationID             =   $callbackData->ConversationID;
                $transactionID              =   $callbackData->TransactionID;
                $accountBalance             =   $callbackData->ResultParameters->ResultParameter[0]->Value;
                $BOCompletedTime            =   $callbackData->ResultParameters->ResultParameter[1]->Value;

                $result                     =   array(
                                                        "resultDesc"                  =>$resultDesc,
                                                        "resultCode"                  =>$resultCode,
                                                        "originatorConversationID"    =>$originatorConversationID,
                                                        "conversationID"              =>$conversationID,
                                                        "transactionID"               =>$transactionID,
                                                        "accountBalance"              =>$accountBalance,
                                                        "BOCompletedTime"             =>$BOCompletedTime,
                                                        "resultType"                  =>$resultType
                                                    );

            }
        public function processReversalRequestCallBack(Request $request)
            {


                $callbackData               =   $request;
                $resultType                 =   $callbackData->ResultType;
                $resultCode                 =   $callbackData->ResultCode;
                $resultDesc                 =   $callbackData->ResultDesc;
                $originatorConversationID   =   $callbackData->OriginatorConversationID;
                $conversationID             =   $callbackData->ConversationID;
                $transactionID              =   $callbackData->TransactionID;

                $result                     =   array(
                                                        "resultType"                  =>$resultType,
                                                        "resultCode"                  =>$resultCode,
                                                        "resultDesc"                  =>$resultDesc,
                                                        "conversationID"              =>$conversationID,
                                                        "transactionID"               =>$transactionID,
                                                        "originatorConversationID"    =>$originatorConversationID
                                                    );


            }
        public function processSTKPushRequestCallback(Request $request)
            {

                $callbackData       =   $request->Body;
                $resultCode         =   $callbackData->stkCallback->ResultCode;
                $resultDesc         =   $callbackData->stkCallback->ResultDesc;
                $merchantRequestID  =   $callbackData->stkCallback->MerchantRequestID;
                $checkoutRequestID  =   $callbackData->stkCallback->CheckoutRequestID;
                $amount             =   $callbackData->stkCallback->CallbackMetadata->Item[0]->Value;
                $mpesaReceiptNumber =   $callbackData->stkCallback->CallbackMetadata->Item[1]->Value;
                $balance            =   $callbackData->stkCallback->CallbackMetadata->Item[2]->Value;
                $transactionDate    =   $callbackData->stkCallback->CallbackMetadata->Item[3]->Value;
                $phoneNumber        =   $callbackData->stkCallback->CallbackMetadata->Item[4]->Value;

                $result             =   array(
                                                "resultDesc"=>$resultDesc,
                                                "resultCode"=>$resultCode,
                                                "merchantRequestID"=>$merchantRequestID,
                                                "checkoutRequestID"=>$checkoutRequestID,
                                                "amount"=>$amount,
                                                "mpesaReceiptNumber"=>$mpesaReceiptNumber,
                                                "balance"=>$balance,
                                                "transactionDate"=>$transactionDate,
                                                "phoneNumber"=>$phoneNumber
                                            );


            }
        public function processSTKPushQueryRequestCallback(Request $request)
            {

                $callbackData 			=	$request;
                $responseCode 			=	$callbackData->ResponseCode;
                $responseDescription 	=	$callbackData->ResponseDescription;
                $merchantRequestID 		=	$callbackData->MerchantRequestID;
                $checkoutRequestID 		=	$callbackData->CheckoutRequestID;
                $resultCode 			=	$callbackData->ResultCode;
                $resultDesc 			=	$callbackData->ResultDesc;

                $result                 =   array(
                                                    "resultCode" 			=>	$resultCode,
                                                    "responseDescription" 	=>	$responseDescription,
                                                    "responseCode" 			=>	$responseCode,
                                                    "merchantRequestID" 	=>	$merchantRequestID,
                                                    "checkoutRequestID" 	=> 	$checkoutRequestID,
                                                    "resultDesc" 			=>	$resultDesc
                                                );


            }
        public function processTransactionStatusRequestCallback(Request $request)
            {

                $callbackData               =   $request->Result;
                $resultCode                 =   $callbackData->ResultCode;
                $resultDesc                 =   $callbackData->ResultDesc;
                $originatorConversationID   =   $callbackData->OriginatorConversationID;
                $conversationID             =   $callbackData->ConversationID;
                $transactionID              =   $callbackData->TransactionID;
                $ReceiptNo                  =   $callbackData->ResultParameters->ResultParameter[0]->Value;
                $ConversationID             =   $callbackData->ResultParameters->ResultParameter[1]->Value;
                $FinalisedTime              =   $callbackData->ResultParameters->ResultParameter[2]->Value;
                $Amount                     =   $callbackData->ResultParameters->ResultParameter[3]->Value;
                $TransactionStatus          =   $callbackData->ResultParameters->ResultParameter[4]->Value;
                $ReasonType                 =   $callbackData->ResultParameters->ResultParameter[5]->Value;
                $TransactionReason          =   $callbackData->ResultParameters->ResultParameter[6]->Value;
                $DebitPartyCharges          =   $callbackData->ResultParameters->ResultParameter[7]->Value;
                $DebitAccountType           =   $callbackData->ResultParameters->ResultParameter[8]->Value;
                $InitiatedTime              =   $callbackData->ResultParameters->ResultParameter[9]->Value;
                $OriginatorConversationID   =   $callbackData->ResultParameters->ResultParameter[10]->Value;
                $CreditPartyName            =   $callbackData->ResultParameters->ResultParameter[11]->Value;
                $DebitPartyName             =   $callbackData->ResultParameters->ResultParameter[12]->Value;

                $result                     =   array(
                                                        "resultCode"                =>  $resultCode,
                                                        "resultDesc"                =>  $resultDesc,
                                                        "originatorConversationID"  =>  $originatorConversationID,
                                                        "conversationID"            =>  $conversationID,
                                                        "transactionID"             =>  $transactionID,
                                                        "ReceiptNo"                 =>  $ReceiptNo,
                                                        "ConversationID"            =>  $ConversationID,
                                                        "FinalisedTime"             =>  $FinalisedTime,
                                                        "Amount"                    =>  $Amount,
                                                        "TransactionStatus"         =>  $TransactionStatus,
                                                        "ReasonType"                =>  $ReasonType,
                                                        "TransactionReason"         =>  $TransactionReason,
                                                        "DebitPartyCharges"         =>  $DebitPartyCharges,
                                                        "DebitAccountType"          =>  $DebitAccountType,
                                                        "InitiatedTime"             =>  $InitiatedTime,
                                                        "OriginatorConversationID"  =>  $OriginatorConversationID,
                                                        "CreditPartyName"           =>  $CreditPartyName,
                                                        "DebitPartyName"            =>  $DebitPartyName
                                                    );

            }
    }


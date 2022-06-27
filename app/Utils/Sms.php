<?php
namespace App\Utils;

use App\Constants\SmsAttributes;
use App\Constants\VasAttributes;
use \Exception;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Sms
	{

		public function getAccessTokens()
			{
			    try
					{
                        $data   =   Http::withHeaders(['Content-Type'=>'application/json', 'X-Requested-With'=>'XMLHttpRequest'])
                                        ->withOptions(['verify' => app_path(VasAttributes::cert), 'http_errors' => false])
                                        ->post(SmsAttributes::accesstokenurl, ['username' => SmsAttributes::apiusername, 'password' => SmsAttributes::apipassword]);
                        if($data->successful())
                            {
                                $objbody    =   json_decode($data->body());
                                return  $objbody;
                            }

                    }
				catch(Exception $e)
					{
					    Log::error("Access Token : ".$e->getMessage());
					}
			}
		public function getRefreshToken($refreshToken)
			{
				try
					{
					    $data   =   Http::withHeaders(['Content-Type'=>'application/json', 'X-Requested-With'=>'XMLHttpRequest'])
                                        ->get(SmsAttributes::refreshtokenurl);
                        if($data->successful())
                            {
                                $objbody    =   json_decode($data->body());
                                return  $objbody;
                            }

                    }
                catch(Exception $e)
                    {
                        Log::error("Refreshtoken : ".$e->getMessage());
                    }
			}
		public function envoke_server($url,$data)
			{
				try
					{
					    $dat   =   Http::withHeaders(['Content-Type'=>'application/json'])
                                        ->withToken($this->getAccessTokens())
                                        ->withOptions(['verify' => app_path(VasAttributes::cert), 'http_errors' => false])
                                        ->post($url,$data);

                        if($dat->successful())
                            {
                                $objbody    =   json_decode($dat->body());
                                return  $objbody;
                            }
					}
				catch (Exception $e)
					{
						return array('error'=>$e->getMessage());
					}
			}
		public function bulkSms($new_sdp_data)
			{
				$json_data  =   array(
										"timeStamp" => time(),
										"dataSet" => [
														array(
																"userName"          =>  $new_sdp_data['userName'],
																"channel"           =>  "sms",
																"packageId"         =>  $new_sdp_data['packageId'],
																"oa"                =>  $new_sdp_data['oa'],
																"msisdn"            =>  $new_sdp_data['msisdn'],
																"message"           =>  $new_sdp_data['message'],
																"uniqueId"          =>  $new_sdp_data['msgid'],
																"actionResponseURL" =>  SmsAttributes::bulkSmsCallback
															)
													]
									);

				$data       =   $json_data;
				echo $data;
				$result     =   $this->envoke_server(SmsAttributes::BulkSendUrl,$data);
				if ($result)
					{
						return $result;
					}
				return FALSE;
			}
		public function sendSms($dt)
			{

				$data   =   array(
									[ "name" => "LinkId"    , 'value' => $dt['linkid']    ],
									[ 'name' => 'Msisdn'    , 'value' => $dt['phone']     ],
									[ 'name' => 'OfferCode' , 'value' => $dt['offercode'] ],
									[ 'name' => 'Content'   , 'value' => $dt['msg']       ],
					                [ 'name' => 'CpId'      , 'value' => SmsAttributes::cpid 	  ]
								);

				$json_data  =   array(
										"requestId"         => $dt['id'],
										"channel"           => "APIGW",
										"operation"         => "SendSMS",
										"requestParam"      =>  array("data" => $data)

									);
				try{
					log_message('Error',"Test ".json_encode($json_data));
						$result     =   $this->envoke_server(SmsAttributes::sendSmsUrl,$json_data);

						if ($result)
							{
								return $result;
							}
						return FALSE;
					}
				catch(Exception $e)
					{
						echo $e->getMessage();
					}

			}
		public function subscription($dt)
			{
				$data   =   array(
									[ 'name' => 'OfferCode' , 'value' => $dt['offercode'] ],
									[ 'name' => 'Msisdn'    , 'value' => $dt['phone']     ],
									[ "name" => "Language"  , 'value' => 'English'    ],
									[ 'name' => 'CpId'      , 'value' => SmsAttributes::cpid      ]
								);
				$json_data  =   array(
										"requestId"         =>  $dt['id'],
										"requestTimeStamp"  =>  date('YmdHis'),
										"channel"           =>  "SMS",
										"operation"         =>  "ACTIVATE",
										"requestParam"      =>  array("data" => $data)
									);
				return $this->envoke_server(SmsAttributes::subscriptionUrl,$json_data);
			}
		public function unsubscription(Request $request,$dt)
			{
				$data   =   array(
									[ 'name' => 'OfferCode' , 'value' => $dt['offercode'] ],
									[ 'name' => 'Msisdn'    , 'value' => $dt['phone']     ],
									[ 'name' => 'CpId'      , 'value' => SmsAttributes::cpid      ]
								);
				$json_data  =   array(
										"requestId"         =>  $dt['id'],
										"requestTimeStamp"  =>  date('YmdHis'),
										"channel"           =>  "SMS",
										"sourceAddress"     =>  $request->ip(),
										"operation"         =>  "DEACTIVATE",
										"requestParam"      =>  array("data" => $data)
									);
				return $this->envoke_server(SmsAttributes::unSubscriptionUrl,$json_data);
			}
		public function cpNotification($dt,$additionaldata = NULL)
			{
				$data   =   array(
									[ 'name' => 'OfferCode' , 'value' => $dt['offercode'] ],
									[ 'name' => 'Msisdn'    , 'value' => $dt['phone']     ],
									[ 'name' => 'Command'   , 'value' => $dt['command']   ]
								);
				$json_data  =   array(
										"requestId"         =>  $dt['id'],
										"requestTimeStamp"  =>  date('YmdHis'),
										"operation"         =>  "CP_NOTIFICATION",
										"requestParam"      =>  array("data" => $data)
									);
				if(is_array($additionaldata))
					{
						foreach($additionaldata as $key => $value)
							{
								$json_data["additionalData"][] = array( 'name' => $key , 'value' => $value );
							}
					}
			}
	}

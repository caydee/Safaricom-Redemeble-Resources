<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateVouchers;
use App\Jobs\DirectRedeem;
use App\Models\Batch;
use App\Models\Organization;
use App\Models\OrgProduct;
use App\Models\Product;
use App\Models\Voucher;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VouchersController extends Controller
{
    //
    public function index()
    {

        return view('modules.vouchers.index',$this->data);
    }

    public function get(Request $request)
    {
        $user = auth()->user();
        $company = Organization::where('user_id',$user->id)->limit(1)->first();

        $columns        =   array( 0 => 'voucher' , 1 => 'company' , 2 => 'status' );
        $totalData      =   Voucher::where('organization_id',$company->id)->count();
        $totalFiltered  =   $totalData;
        $limit          =   $request->input('length');
        $start          =   $request->input('start');
        $order          =   $columns[$request->input('order.0.column')];
        $dir            =   $request->input('order.0.dir');

        if( empty(  $request->input('search.value') )  )
        {
            $posts = Voucher::where('organization_id',$company->id)->offset($start)
                ->limit($limit)
                //->orderBy($order,$dir)
                ->get();
        }
        else
        {

            $search         =   $request->input('search.value');
            $posts          =   Voucher::where('voucher','LIKE',"%{$search}%")
                                        ->where('organization_id',$company->id)
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();

            $totalFiltered  =   Voucher::where('voucher','LIKE',"%{$search}%")->where('organization_id',$company->id)
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $pos    =   $start+1;
            foreach ($posts as $post)
            {
                $actionbtn = '<a href="'.route('product.edit',$post->id).'"  class="text-dark mr-3" ><i class="fas fa-edit  "></i></a>';

                $actionbtn =   (   $post->active == 1   )?"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>0])."'><i class='fas fa-eye-slash'></i></a>":
                    "<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>1])."'><i class='fas fa-eye'></i></a>";
                $actionbtn = '';
                $nestedData['pos']      =   $pos;
                $nestedData['voucher']     =   substr($post->voucher,0,4).'############';
                $nestedData['voucher']     = strtoupper(substr($post->voucher,0,8).$post->id).'############';
                $nestedData['batch']       = $post->batch_id;
                $nestedData['company']     =   strtoupper($post->organization->name);
                $nestedData['status']   =   ($post->active === 1)?'Unused':'Used';
                $nestedData['action']   =   $actionbtn;
                $data[]                 =   $nestedData;
                $pos    += 1;

            }
        }

        $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

        return response()->json($json_data);
    }

    public function getGenerator()
    {
        $this->data['products'] = Product::all();
        return view('modules.vouchers.generate',$this->data);
    }
    public function generate(Request $request)
    {
        $count = $request->count;
        $productid = $request->product;
        $user = auth()->user();
        $company = Organization::where('user_id',$user->id)->limit(1)->first();

        $units = \App\Models\OrgUnits::where('organization_id',$company->id)->limit(1)->first();
        if(is_null($units))
            return self::fail('Vouchers','No units found',route('vouchers.batches.get'));

        if($units->units < $count)
            return self::fail('Vouchers','Not enough units',route('vouchers.batches.get'));

        $batch = new Batch();
        $batch->organization_id = $company->id;
        $batch->count = (int)$count;
        $batch->save();

        $batchno = $batch->id;

        $status = true;
        $data = new \stdClass();
        $data->companyid = $company->id;
        $data->count = $count;
        $data->batchno = $batchno;
        $data->productid = $productid;

        GenerateVouchers::dispatch($data);

        return self::success('Vouchers','Generation Scheduled Successfully',route('vouchers.batches.get'));

    }

    public function batches(Request $request)
    {
        return view('modules.vouchers.batches',$this->data);
    }

    public function getBatches(Request $request)
    {
        $user = auth()->user();
        $company = Organization::where('user_id',$user->id)->limit(1)->first();

        $columns        =   array( 0 => 'id' , 1 => 'company' , 2 => 'status' );
        $totalData      =   Batch::where('organization_id',$company->id)->count();
        $totalFiltered  =   $totalData;
        $limit          =   $request->input('length');
        $start          =   $request->input('start');
        $order          =   $columns[$request->input('order.0.column')];
        $dir            =   $request->input('order.0.dir');

        if( empty(  $request->input('search.value') )  )
        {
            $posts = Batch::where('organization_id',$company->id)->offset($start)
                ->limit($limit)
                //->orderBy($order,$dir)
                ->get();
        }
        else
        {

            $search         =   $request->input('search.value');
            $posts          =   Batch::where('id','LIKE',"%{$search}%")
                ->where('organization_id',$company->id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered  =   Batch::where('id','LIKE',"%{$search}%")->where('organization_id',$company->id)
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $pos    =   $start+1;
            foreach ($posts as $post)
            {
                $actionbtn = '<a href="'.route('product.edit',$post->id).'"  class="text-dark mr-3" ><i class="fas fa-edit  "></i></a>';

                $actionbtn =   (   $post->active == 1   )?"<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>0])."'><i class='fas fa-eye-slash'></i></a>":
                    "<a href='javascript:;' class='text text-muted chact' data-id='".$post->id."' data-table='rr_users' data-data='".json_encode(['status'=>1])."'><i class='fas fa-eye'></i></a>";
                $actionbtn = '';
                $nestedData['pos']      =   $pos;
                $nestedData['batch']    = $post->id;
                $nestedData['count']     =   $post->count;
                $nestedData['company']     =  strtoupper($post->organization->name);
                $nestedData['status']   =   ($post->status === 1)? 'Complete':'Incomplete';
                $nestedData['action']   =   $actionbtn;
                $data[]                 =   $nestedData;
                $pos    += 1;

            }
        }

        $json_data = array( "draw" => (int)$request->input('draw') , "recordsTotal" => $totalData , "recordsFiltered" => $totalFiltered , "data" => $data );

        return response()->json($json_data);
    }

    public function generateApi(Request $request)
    {
        $count = $request->count;
        $productid = $request->product;
        $user = $request->user();
        //return response()->json($user);

        $company = Organization::where('user_id',$user->id)->limit(1)->first();
        if(is_null($productid))
        {
            $message = [
                'status'=>'error',
                'message'=>'Required parameter: product missing or is invalid'
            ];
            return response()->json($message);
        }

        if(is_null($count))
        {
            $message = [
                'status'=>'error',
                'message'=>'Required parameter: count missing or is invalid'
            ];
            return response()->json($message);
        }

        if(is_null($company))
        {
            $message = [
                'status'=>'error',
                'message'=>'Company not found'
            ];
            return response()->json($message);
        }

        $units = \App\Models\OrgUnits::where('organization_id',$company->id)->where('product_id',$productid)->limit(1)->first();
        if(is_null($units))
        {
            $message = [
                'status'=>'error',
                'message'=>'No units found for that product'
            ];
            return response()->json($message);
        }

        if($units->units < $count)
        {
            $message = [
                'status'=>'error',
                'message'=>'Not enough units '
            ];
            return response()->json($message);
        }

        $batch = new Batch();
        $batch->organization_id = $company->id;
        $batch->count = (int)$count;
        $batch->save();

        $batchno = $batch->id;

        $data = new \stdClass();
        $data->companyid = $company->id;
        $data->count = $count;
        $data->batchno = $batchno;
        $data->productid = $productid;

        GenerateVouchers::dispatch($data);
        $message = [
            'status'=>'success',
            'batch_number'=>$batchno,
            'message'=>'Batch successfully added to queue for processing'
        ];

        return response()->json($message);
    }

    public function generateVoucherApi(Request $request)
    {
        $user = $request->user();
        $company = Organization::where('user_id',$user->id)->limit(1)->first();
        $companyid = $company->id;
        $productid = $request->product;
        $count = 1;
        $batchno = 0;
        $status = true;
        $voucherref = null;

        if(is_null($productid))
        {
            $message = [
                'status'=>'error',
                'message'=>'Required parameter: product missing or is invalid'
            ];
            return response()->json($message);
        }

        DB::transaction(
            function () use($companyid,$productid,$count,$batchno,&$status,&$voucherref){
                $units = \App\Models\OrgUnits::lockForUpdate()->where('organization_id',$companyid)->where('product_id',$productid)->limit(1)->first();
                if(is_null($units))
                {
                    $status = false;
                    return;
                }

                if($units->units < $count)
                {
                    $status = false;
                    return;
                }

                {
                    $data = [];
                    $data['voucher'] = Str::uuid()->toString();
                    $data['batch_id'] = $batchno;
                    $data['product_id'] = $productid;
                    $data['organization_id']= $companyid;
                    $data['active'] = 1;
                    $voucher = new Voucher($data);
                    $voucher->save();
                }
                $units->units = ($units->units - $count);
                $units->save();
                $voucherref = $voucher;
            }
        );

        if(!$status)
        {
            $message = [
                'status'=>'error',
                'message'=>'Not enough units for that product'
            ];
            return response()->json($message);
        }


        $message = [
            'status'=> 'success',
            'voucher'=> 'T'.strtoupper(substr($voucherref->voucher,0,8).$voucherref->id),
        ];
        return response()->json($message);
    }

    public function getOrganizationProducts(Request $request)
    {
        $offset = $request->offset ?? 0;
        $size = $request->size ?? 100;
        $user = $request->user();
        $company = Organization::where('user_id',$user->id)->limit(1)->first();

        $products = Product::join('org_products','org_products.product_id','=','products.id')
            ->where('organization_id',$company->id)
            ->offset($offset)->limit($size)->get(['products.id','products.name']);
        $data = [
            'status'=>'success',
            'products'=>$products
            ];

        return response()->json($data);
    }

    public function directDispatchApi(Request $request)
    {
        $productid = $request->product;
        $mssisdn = $request->msisdn;
        $user = $request->user();
        $company = Organization::where('user_id',$user->id)->limit(1)->first();

        $product = Product::join('org_products','org_products.product_id','=','products.id')
            ->where('organization_id',$company->id)->where('products.id',$productid)
            ->get(['products.id','products.name','products.sender_name'])->first();

        if(is_null($product))
        {
            $message = [
                'status'=> 'error',
                'message'=> 'Invalid product ID '.$productid,
            ];
            return response()->json($message);
        }

        $data = new \stdClass();
        $data->sender_name = $product->sender_name;
        $data->product_id = $product->id;
        $data->organization_id = $company->id;
        $data->msisdn = $mssisdn;
        DirectRedeem::dispatch($data);
        $message = [
            'status'=>'success',
            'message'=>'product redeemed successfully'
        ];
        return response()->json($message);
    }
}

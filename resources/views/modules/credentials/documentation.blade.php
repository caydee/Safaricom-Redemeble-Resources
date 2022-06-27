@extends('includes.body')
@section('content')

        <div class="col">


            <div class="row">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <h1 class="text-center">Welcome to Tamaituk Labs</h1>
                    <p class="lead text-center mb-4">You’ll find guides and documentation to help you get familiar with our products and learn how to integrate them to build powerful mobile solutions.</p>
                    <hr>

                </div>
            </div>

            <div class="row w-100">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Authentication</h5>
                        </div>
                        <div class="card-body">
                            <div id="contents">

                                <p>End point: POST <strong><code>https://tamaituk.caydeesoft.com/oauth/token</code></strong></p>
                               <p> Paramenters</p>
                                <pre class="snippet">
                                    <code class="php">

                                {

                                "grant_type":"password",
                                "username": "xxxx@gmail.com",
                                "password": "xxxxx",
                                "client_id": 1,
                                "client_secret":"ew0HpbnQDNrMqafgjVrw8COA3gfDWwrZOmmI7LD5"
                                }
                                    </code>
                                </pre>
                                <p>Returns</p>
                                <p>On Success</p>
                                <p>Access token and refresh tokens  .e.g</p>

                                <pre class="snippet">
                                    <code class="php">
                                        {
                                        "token_type": "Bearer",
                                        "expires_in": 7200,
                                        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZGQwZmNlYmM3Y2Y0ZTQ4YWQwNzk1NDJlZjMwZWM0YzMyZGQ3MGVmZDNkYjMyZDIzNTNlZTkxOWRjMzk4MDljNTZiZmViMjZkYzdjNzE3NjMiLCJpYXQiOjE2MzMyNjgwNzcuOTY1MDYyLCJuYmYiOjE2MzMyNjgwNzcuOTY1MDY4LCJleHAiOjE2MzMyNzUyNzcuOTA5ODA1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.ZqApPwe_4l3ojhrXPVcjOxsiR6JNprG73FotRISm8Of0YbdRJR7P5Y_Olv1u3y5Tkz9FzOf0Twwb3AxXeu53c9e2XoLTaWG8ivysfbXgK-cF4xh3o2SbHs8qgNgGv1TZlpE1UqkVncM-eeAlqE-Nqtzm1f-ojFnn7-MGyV6wnf24Z-JN31O4sAZPyNKAURV-yHxrS4pFZ3SFkZpUcFOfUYzJY9Kc4nL9ANeKVQCEzBUUfpJy0b1DrouLv019462mX8jSZQ9JCBJsIxTXw92y7SGxRot8xbFPZSig7I809WE_alLH9GhcLLaUu4okp6gAVC8aO-hQMJWN1z-pD-f0GUJgx1lgRZQww5FN0d8gCv0_R6_ESj_kNMT-RrJ3U4WqVCxCc49vOVXTByW0Iu84HTmaSNosCCVOmXkDWsViINu6Zr4379zaqkZ1w-43QnCADvShYmJeXsYGKJSAN3G1S039zF8d9yWgkN7rk0qN-WZPccQHi0s6Ohf37eCRflAeqkrSRMFcAoFP_eLE5gtgTym1B9FY8iKvAS8isexrVTUMDMNFMOf4-jkhl4QTJ5nVWQrC1yT67hexwvGGSlK0yyQw5oKXvfrMlA_WXfCJIxNn62xkyNDIT-kivXnIgkd3QW8djoHJrlsiUXsjwEhANWvEiBz4E8FCIVvE0LYrsYE",
                                        "refresh_token": "def50200edbacda7fe0e019f40dca2a14ea58bec3be75548262104d6267c54ae6f9d9bf52423e5bfe04b430553f32313680e22c4f3d8b622dfb3d3b6d3218b03131dfff3887cc30e41473c43e0b49ed24b4202c021af0f1b8efdd8e039841cb0122cbc0473e3e388b75272e80b9e3bc9abba9859c4f6be09aad761cf60ba858cfe640c24ca0afc42c9d28d9029ae42c5feec34e1f51f2cd673cbd45e90f6bcf5010e46e787f6da260ddd20597fc7b636bb4fd3c2ebaa51b03e31243b1ad9fb0c264cf22983e5cbb5b52e7507246f226aeb851abe82551e0a46b1a9cf8847429e3b77a6fbfea32e2af0c7612b7381b71eafb62977490cd083bf25a43557b0c95179365567217cce62a1fa6a065b16ec1ac43b7755f91c91968e33d0fc3fa5e2e18d1f8aa17ca1afe5ba5e93407afbf958ed37115b2eb9c71163a39f145f2cd03c177326b1b4a68e3c9113700f2eb383c7c7f9b20cf894e84dd1ca77bdfa3d8a81d5"
                                        }
                                    </code>
                                </pre>
                                <p><strong>On failure</strong></p>
                                <p>Error message e.g</p>
                                <pre class="snippet">
                                    <code class="php">
                                {
                                "error": "invalid_client",
                                "error_description": "Client authentication failed",
                                "message": "Client authentication failed"
                                }
                                    </code>
                                </pre>



                            </div>
                            <!-- /#contents -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">GENERATING A NEW ACCESS TOKEN USING A REFRESH TOKEN</h5>
                        </div>
                        <div class="card-body">

                            <div id="new-token">

                                <p>End point : POST <strong><code>https://tamaituk.caydeesoft.com/oauth/token</code></strong></p>
                                <pre class="snippet">
                                    <code class="php">
                                {

                                "grant_type":"refresh_token",
                                "refresh_token":"def50200edbacda7fe0e019f40dca2a14ea58bec3be75548262104d6267c54ae6f9d9bf52423e5bfe04b430553f32313680e22c4f3d8b622dfb3d3b6d3218b03131dfff3887cc30e41473c43e",
                                "client_id": 2,
                                "client_secret":"D6iKoo5TeLPis6AE9HP0wyrMr3iIuAOWBuyovHmc"
                                }
                                    </code>
                                </pre>
                                <p><strong>Returns</strong></p>
                                <p>On success a new pair of access and refresh tokens</p>

                                <p>On failure , an error message e.g.</p>
                                <pre class="snippet">
                                    <code class="php">
                                    {
                                    "error": "invalid_request",
                                    "error_description": "The refresh token is invalid.",
                                    "hint": "Token has been revoked",
                                    "message": "The refresh token is invalid."
                                    }
                                    </code>
                                </pre>
                            </div>
                            <!-- /#introduction -->

                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">GET ORGANISATION PRODUCTS</h5>
                        </div>
                        <div class="card-body">
                            <div id="products">
                                <p>End point: GET <code><strong>https://tamaituk.caydeesoft.com/api/products</strong></code></p>
                                <p><strong>Headers</strong></p>
                                <p>Bearer <code>{access_token}</code></p>
                                <p> Returns a list of all products assigned to an organization or an empty list if none are available.</p>
                                <pre class="snippet">
                                    <code class="json">
                                {
                                "status": "success",
                                "products": [
                                  	{
                                "id": 1,
                                "name": "DATA_20MB"
                                }
                                ],
                                }
                                    </code>
                                </pre>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">GENERATE VOUCHER</h5>
                        </div>
                        <div class="card-body">
                            <div id="voucher">
                                <p>End point: GET <code>https://tamaituk.caydeesoft.com/api/generate-voucher</code></p>

                                <p><strong>Headers</strong></p>
                                <p>Bearer <code>{access_token}</code></p>
                                <p><strong>Parameters</strong></p>
                                <p><i>product</i> : This is the identifier of the product the voucher is for.</p>
                                <p>On success returns a success message with a valid voucher</p>
                                <pre class="snippet">
                                    <code class="json">
                                {
                                "status": "success",
                                "voucher": "TEA7D12624"
                                }
                                    </code>
                                </pre>
                                <p>On error returns an error message</p>


                                <pre class="snippet">
                                    <code class="json">
                                {
                                "status": "error",
                                "message": "Not enough units for that product"
                                }
                                    </code>
                                </pre>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">REDEEM VOUCHER</h5>
                        </div>
                        <div class="card-body">
                            <div id="redeem">
                                <p>End point: POST <code>https://tamaituk.caydeesoft.com/api/redeem</code></p>
                                <p><strong>Headers</strong></p>
                                <p>Bearer {access_token}</p>
                                <p><strong>Parameters</strong></p>
                                <pre class="snippet">
                                    <code class="json">
                                {
                                "msisdn":"2547012134XX",
                                "product": 2
                                }
                                    </code>
                                </pre>
                                <p><i>msisdn</i> : This is the phone number that receives a product bundle e.g. DATA.</p>
                                <p><i>product</i> : This is the identifier of the product e.g. DATA or SMS etc.</p>
                                <p><strong>Returns</strong></p>
                                <p>On <i>success</i>, a success message.</p>
                                <pre class="snippet">
                                    <code class="json">
                                {
                                "status": "success",
                                "message": "product redeemed successfully"
                                }
                                    </code>
                                </pre>
                                <p>On <i>failure</i> an error message e.g.</p>

                                <pre class="snippet">
                                    <code class="json">
                                    {
                                        "status": "error",
                                        "message": "Invalid product ID XX"
                                    }

                                    </code>
                                </pre>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

@endsection
@section('header')

@endsection
@section('footer')

@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
    {
        public function type($x)
            {
                switch($x)
                    {
                        case 0:
                            return 'faq';
                        case 1:
                            return 'ticket';
                    }
            }
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function index($ticket)
            {
                $this->data['type'] =   $this->type($ticket);
                return view('modules.ticket.index',$this->data);
            }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function create($ticket)
            {
                $this->data['type'] =   $this->type($ticket);
                return view('modules.ticket.add',$this->data);
            }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request,$ticket)
            {
                //
            }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View|string
         */
        public function show($ticket,$id)
            {
                $this->data['type']     =   $this->type($ticket);
                $this->data['ticket']   =   Ticket::find($id);
                return view('modules.ticket.view',$this->data);
            }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($ticket,$id)
            {
                $this->data['type']     =   $this->type($ticket);
                $this->data['ticket']   =   Ticket::find($id);
                return view('modules.ticket.edit',$this->data);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $ticket,$id)
            {
                //
            }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($ticket,$id)
            {
                //
            }
        public function get(Request $request,$ticket)
            {

            }
    }

@php
    $pageName = "reports";
@endphp

@extends('layouts.app')

@section('content')
<main id="reports">
   <div id="head">
      <h2>Reports</h2>
      <br>
      <div id="description">
         <p>Review user reports and decide how they should be handled</p>
      </div>
   </div>
   <div class="row messages">
   </div>
   <div id="body">  
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <div class="container mt-5">
         <div class="row">
            <div class="col-lg-12">
               <div class="main-box clearfix">
                  <div class="table-responsive">
                     <table class="table user-list">
                        <thead>
                           <tr>
                              <th><span>Reported User</span></th>
                              <th><span>Reported by</span></th>
                              <th class="text-center"><span>Date</span></th>
                              <th class="text-center"><span>Status</span></th>
                              <th class="text-center"><span>Content</span></th>
                              <th class="text-center"><span>Reason</span></th>
                              <th class="text-center"><span>Action</span></th>
                           </tr>
                        </thead>
                        @if(count($reports) !== 0)
                           <tbody>
                              @for($numReport = 0; $numReport < count($reports); $numReport++)
                                 @include('partials.report')
                              @endfor
                           </tbody>
                        @endif
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @if(count($reports) === 0)
         <div class="offset-md-2 col-md-8 empty_message">Reports list is empty.</div>
      @endif
   </div>
</main>
@endsection
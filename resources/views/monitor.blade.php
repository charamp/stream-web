@extends('layouts.master')

@section('monitor')


<main class='main-container'>

<!--button class="test">SWAP</button-->

    <table class='alarm-table' alarm-table>
        <thead>
            <tr>
                <td>Id</td>
                <td>Position</td>
                <td>Result</td>
                <td>Triggered Time</td>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <button class='alarm-table__button' alarm-table-more>load more</div>
</main>

<section class='splash-screen' splash-screen>
    <img class='splash-screen__logo' src='img/logo.png'>
</section>




<!--button class="test2">card</button-->

  <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="row"> 
        <div class="col s12">
          <h4>Alarm</h4>
        </div>
        <div class="col s12">
          <div class="row">

            <div class="input-field col s6">
              <input disabled value=" " id="service-type" type="text" class="validate">
              <label for="service-type">Service Type</label>
            </div>

            <div class="input-field col s6">
              <input disabled value=" " id="alarm-type" type="text" class="validate">
              <label for="alarm-type">Alarm Type</label>
            </div>

          </div>
          <div class="row">

            <div class="input-field col s6">
              <input disabled value=" " id="node-name" type="text" class="validate">
              <label for="node-name">Node Name</label>
            </div>
            <div class="input-field col s6">
              <input disabled value=" " id="rack-number" type="text" class="validate">
              <label for="rack-number">Rack Number</label>
            </div>

          </div>
          <div class="row">

            <div class="input-field col s6">
              <input disabled value=" " id="card-number" type="text" class="validate">
              <label for="card-number">Card Number</label>
            </div>
            <div class="input-field col s6">
              <input disabled value=" " id="port-number" type="text" class="validate">
              <label for="port-number">Port Number</label>
            </div>

          </div>
          <div class="row">

            <div class="input-field col s6">
              <input disabled value=" " id="splitter1-number" type="text" class="validate">
              <label for="splitter1-number">Splitter Number</label>
            </div>
            <div class="input-field col s6">
              <input disabled value=" " id="splitter2-number" type="text" class="validate">
              <label for="splitter2-number">Splitter2 Number</label>
            </div>

          </div>
          <div class="row">

            <div class="input-field col s12">
              <table class="customer-table" customer-table>
                <thead>
                  <tr>
                    <td>Customer Id</td>
                    <td>Loss Carrier Time</td>
                    <td>Status</td>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>

          </div>

        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>

@foreach ($result as $alarm)

@endforeach

@stop


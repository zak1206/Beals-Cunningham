<?php
class packageCall
{
  function runOutput($comid)
  {
    include('inc/config.php');

    $html .= '
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Get Finalized Quote</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="package_builder_form" id="package_builder_form" role="form" method="post" action="processform">
    <div class="row">
        <input type="hidden" name="equipment-type" id="equipment-type" value=""/>
        <input type="hidden" name="general-information" id="general-information" value=""/>
        <input type="hidden" name="payment-information" id="payment-information" value=""/>
        <div class="col-md-6">
            <labal>First Name</labal><br>
            <input type="text" name="first_name" id="first_name" class="form-control" required/>
        </div>
        <div class="col-md-6">
            <labal>Last Name</labal><br>
            <input type="text" name="last_name" id="last_name" class="form-control" required/>
        </div>
        <div class="col-md-6">
            <labal>Email</labal><br>
            <input type="email" name="email" id="email" class="form-control" required/>
        </div>
        <div class="col-md-6">
            <labal>Phone</labal><br>
            <input type="tel" name="phone" id="phone" class="form-control" required/>
        </div>
          <div class="col-md-12">
            <labal>Zip</labal><br>
            <input type="tel" name="zip" id="zip" class="form-control" required/>
        </div>
        <div class="col-md-12">
            <!--<label>I would like to pay for this item by</label><br>
            <input type="checkbox" id="cashpayment" name="cashpayment">
            <label for="cashpayment">Cash Payment</label><br>
            <input type="checkbox" id="onlinepayment" name="onlinepayment">
            <label for="onlinepayment">Online Payment</label><br>-->
            <input type="radio" name="paymentby" value="cash">Cash
            <input type="radio" name="paymentby" value="online">Online

        </div>
        <div class="col-md-12">
        <label>Comments</label>
        <textarea name="comments" id="comments" class="form-control"></textarea>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success" style="border-radius: 0px; background: #097F0E; padding: 10px 30px; text-transform: uppercase; margin-top: 20px;">Finalize Quote!</button>
        </div>
    </div>
</form><div id="success-message"></div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="offersModal" tabindex="-1" role="dialog" aria-labelledby="offersModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header offer-modal-header">
        <h5 class="modal-title">Current Offers & Discounts</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="buildertop"></div><div class="container-fluid"> 
                    <div class="mb-5 bg-white shadow-sm"> 
                    <h3>Build Your Own</h3> 
                    <div id="stepper1" class="bs-stepper"> 
                    <div class="bs-stepper-header" role="tablist"> 
                    <div class="step" data-target="#test-l-1"> 
                    <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1" onclick="location.reload()"> <span class="bs-stepper-circle">1</span> <span class="bs-stepper-label"></span> Select Equipment </button>
                     </div> <div class="bs-stepper-line">
                     </div> 
                     <div class="step" data-target="#test-l-2"> <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2"  onclick="stepper.previous(2)" > <span class="bs-stepper-circle">2</span> 
                     <span class="bs-stepper-label">Implements</span> </button> </div> <div class="bs-stepper-line"></div> <div class="step" data-target="#test-l-3"> 
                     <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3"  onclick="stepper.previous(3)"> <span class="bs-stepper-circle">3</span> 
                     <span class="bs-stepper-label">Accessories</span> </button> </div> <div class="bs-stepper-line"></div> <div class="step" data-target="#test-l-4"> 
                     <button type="button" class="step-trigger" role="tab" id="stepper1trigger4" aria-controls="test-l-4"> <span class="bs-stepper-circle">4</span> 
                     <span class="bs-stepper-label">Payments</span> </button> </div> </div> <div class="bs-stepper-content"> 
                     <form name="builder-form" id="builder-form" method="post" action=""> <div id="test-l-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger1">';

    // Get Tractor Packages

    $a = $data->query("SELECT * FROM package_information WHERE active = 'true'");

    $html .= '<div class="build-container"><div class="row">';

    while ($b = $a->fetch_array()) {
      $html .= '<div class="col-md-4 col-lg-4 col-sm-12 builder-container ml-auto mr-auto" data-id="' . $b["package_name"] . '"><div class="card" style="border: none;">';
      $html .= '<img src="' . $b["package_image"] . '" class="img-responsive" style="border-radius: 35px;"/>';
      $html .= '<div class="card-body"><h3 class="package-title">' . $b["package_name"] . '</h3></div>';

      $html .= '</div></div>';
    }

    $html .= '</div>';
    $html .= '<div class="clearfix"></div><div class="col-md-12"><div id="subcatsection" class="subcat"></div></div>';
    $html .= '<div class="clearfix"></div><div class="col-md-12"><div class="equipment"></div></div>';
    $html .= '<div class="clearfix"></div><div class="col-md-12"><div class="implements-container"></div></div></div>';

    //$html .='</div> <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2"> <h2>None Available For This Model</h2> </div> <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3"> </div> <div id="test-l-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger4"> </div> </form> </div> </div> </div> </div>';
    $html .= '</div> <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2"> <h2>None Available For This Model</h2> <button class="btn btn-primary" onclick="stepper.previous()">Previous</button> <button class="btn btn-primary" onclick="stepper.next()">Next</button> </div> <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3"><h2>No Implements Selected</h2> <button class="btn btn-primary mt-5" onclick="stepper.previous()">Previous</button> <button type="submit" class="btn btn-primary mt-5">Submit</button> </div> <div id="test-l-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger4"> <button class="btn btn-primary mt-5" onclick="stepper.previous()">Previous</button> <button type="submit" class="btn btn-primary mt-5">Submit</button> </div> </form> </div> </div> </div> </div>';

    return $html;
  }
}

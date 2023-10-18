<?php
class packageCall
{
    function runOutput($comid)
    {
        include('inc/config.php');

       $html .= '<div id="buildertop"></div><div class="container-fluid"> 
                    <div class="mb-5 bg-white shadow-sm"> 
                    <h3>Tractor Configurator</h3> 
                    <div id="stepper1" class="bs-stepper"> 
                    <div class="bs-stepper-header" role="tablist"> 
                    <div class="step" data-target="#test-l-1"> 
                    <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1"> <span class="bs-stepper-circle">1</span> <span class="bs-stepper-label"></span> Select Equipment </button>
                     </div> <div class="bs-stepper-line">
                     </div> 
                     <div class="step" data-target="#test-l-2"> <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2"> <span class="bs-stepper-circle">2</span> 
                     <span class="bs-stepper-label">Implements</span> </button> </div> <div class="bs-stepper-line"></div> <div class="step" data-target="#test-l-3"> 
                     <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3"> <span class="bs-stepper-circle">3</span> 
                     <span class="bs-stepper-label">Attachments</span> </button> </div> <div class="bs-stepper-line"></div> <div class="step" data-target="#test-l-4"> 
                     <button type="button" class="step-trigger" role="tab" id="stepper1trigger4" aria-controls="test-l-4"> <span class="bs-stepper-circle">4</span> 
                     <span class="bs-stepper-label">Payments</span> </button> </div> </div> <div class="bs-stepper-content"> 
                     <form name="builder-form" id="builder-form" method="post" action=""> <div id="test-l-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger1">';

        // Get Tractor Packages

        $a = $data->query("SELECT * FROM package_information WHERE active = 'true'");

        $html .= '<div class="build-container"><div class="row">';

        while ($b = $a->fetch_array()) {
            $html .= '<div class="col-md-4 col-lg-4 col-sm-12 builder-container" data-id="' . $b["package_name"] . '"><div class="card">';
            $html .= '<img src="' . $b["package_image"] . '" class="img-responsive"/>';
            $html .= '<div class="card-body"><h3 class="package-title">' . $b["package_name"] . '</h3></div>';

            $html .= '</div></div>';
        }

        $html .= '</div>';
        $html .= '<div class="clearfix"></div><div class="col-md-12"><div class="subcat"></div></div>';
        $html .= '<div class="clearfix"></div><div class="col-md-12"><div class="equipment"></div></div>';
        $html .= '<div class="clearfix"></div><div class="col-md-12"><div class="implements-container"></div></div></div>';

        $html .='</div> <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2"> <h2>None Available For This Model</h2> <button class="btn btn-primary" onclick="stepper.previous()">Previous</button> <button class="btn btn-primary" onclick="stepper.next()">Next</button> </div> <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3"> <button class="btn btn-primary mt-5" onclick="stepper.previous()">Previous</button> <button type="submit" class="btn btn-primary mt-5">Submit</button> </div> <div id="test-l-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger4"> <button class="btn btn-primary mt-5" onclick="stepper.previous()">Previous</button> <button type="submit" class="btn btn-primary mt-5">Submit</button> </div> </form> </div> </div> </div> </div>';

        return $html;
    }
}



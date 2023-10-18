<?php


$html .= '<div class="col-md-4">
                    <div class="dragcol" style="padding: 6px; margin: 15px; height: 100vh; overflow: scroll; border-radius: 1px;">
                    <nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a style="display: none;" class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All</a>
						<!--<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false" style="color: black;">Attachments</a>
						<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false" style="color: black;">Implements</a>-->
					</div>
				</nav> 
				<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><label>Search</label><input id="searchlines" name="searchlines" class="form-control" placeholder="search"/><div class="result-container">';

    $alllines = $tractorstuff->getAllAttsImps($equiptitle);
    for($i = 0; $i < count($alllines); $i++) {
        if(!empty($alllines[$i]["category"])) {
            $cat = '<span style="font-size: .6rem;">('.$alllines[$i]["category"].')</span>';
        } else {
            $cat = '';
        }

        $html .= '<div class="productitem draggable" data-thename="' . $alllines[$i]["title"] . '" data-listtype="' . $alllines[$i]["type"] . '"   data-listprice="' . $alllines[$i]["price"] . '" data-id="' . $alllines[$i]["title"] . '" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer; border-radius: 1px; background: #5F8D6D; color: white;"><div class="col-md-12" style="text-align: left"><span class="dragsa" style="cursor:move; text-align: left"><img style="width: 6px; float: left; margin-right: 10px;" src="img/grip.png"></span><p class="parts-name">' . $alllines[$i]["title"] . $cat.' | ' . $alllines[$i]["price"] . '| ' . $alllines[$i]["type"] . '</p><a style="position: absolute; top: 10px; right: 10px; z-index: 9999;" onclick="quickLineEdit(' . $alllines[$i]["id"] . ')"><i class="fa fa-edit"></i></a></div><div class="clearfix"></div></div>';
    }

$html .='</div></div>
					<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
						Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
					</div>
					<div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
						Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
					</div>
				</div>';

?>
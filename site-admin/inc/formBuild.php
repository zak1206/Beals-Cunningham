<?php
class buildForm{
    function build($formJson,$form_name){
        $newArs = json_decode($formJson,true);


        for($i=0; $i < count($newArs); $i++) {
            $inputType = $newArs[$i]["fldTypes"];
            $anyOptions = $newArs[$i]["options"];


            if ($inputType == 'text_field') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                $fieldtype = $newArs[$i]["field"]["fieldtype"];
                $maxlenght = $newArs[$i]["field"]["maxlenght"];
                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                if ($placeHolder != null) {
                    $placeHolder = 'placeholder="' . $placeHolder . '"';
                } else {
                    $placeHolder = '';
                }

                if ($maxlenght != null) {
                    $maxlenght = 'maxlength="' . $maxlenght . '"';
                } else {
                    $maxlenght = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br><input class="' . $fieldclass . '" type="'.$fieldtype.'" name="' . $fieldname . '" id="' . $fieldname . '" value="' . $fieldvalue . '" ' . $placeHolder . ' ' . $maxlenght . ' ' . $required . '></div>';

                $item .= '' . $fieldname . ' VARCHAR(100) NOT NULL,';
            }

            if ($inputType == 'select') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br><select name="' . $fieldname . '" id="' . $fieldname . '" class="' . $fieldclass . '" ' . $required . '>';

                foreach ($anyOptions as $key => $val) {
                    $form .= '<option value="' . $val . '">' . $key . '</option>';
                }

                $form .= '</select></div>';

                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';

            }

            if ($inputType == 'location_selector') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br><select name="' . $fieldname . '" id="' . $fieldname . '" class="' . $fieldclass . '" ' . $required . '>';

                foreach ($anyOptions as $key => $val) {
                    $form .= '<option value="' . $val . '">' . $key . '</option>';
                }

                $form .= '</select></div>';

                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';

            }


            if ($inputType == 'checkbox') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required minlength="1"';
                    $ersLab = '<label for="' . $fieldname . '[]" class="error" style="display:none">Must select at least one</label>';
                } else {
                    $required = '';
                    $ersLab = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br>'.$ersLab;

                if(isset($newArs[$i]["field"]["inline"])){
                    $inline = 'style="display:inline-block; padding:5px"';
                }else{
                    $inline = '';
                }

                $ch=0;
                foreach ($anyOptions as $key => $val) {
                    if($ch == 0){
                        $required = $required;
                    }else{
                        $required = '';
                    }
                    $form .= '<div '.$inline.'><input class="' . $fieldclass . '" type="checkbox" id="'.$fieldclass.''.$ch.'" name="' . $fieldname . '[]" value="' . $val . '" '.$required.'> <label for="'.$fieldclass.''.$ch.'">' . $key . ' </label></div>';
                    $ch++;
                }

                $form .= '</div>';
                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';
            }

            if ($inputType == 'radio') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required minlength="1"';
                    $ersLab = '<label for="' . $fieldname . '" class="error" style="display:none">Must select at least one</label>';
                } else {
                    $required = '';
                    $ersLab = '';
                }

                if(isset($newArs[$i]["field"]["inline"])){
                    $inline = 'style="display:inline-block; padding:5px"';
                }else{
                    $inline = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br>'.$ersLab;

                $ch=0;
                foreach ($anyOptions as $key => $val) {
                    if($ch == 0){
                        $required = $required;
                    }else{
                        $required = '';
                    }
                    $form .= '<div '.$inline.'><input class="' . $fieldclass . '" type="radio" name="' . $fieldname . '" id="' . $fieldname . ''.$ch.'" value="'.$val.'" '.$required.'> <label for="' . $fieldname . ''.$ch.'">' . $key . ' </label></div>';
                    $ch++;
                }

                $form .= '</div>';
                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';

            }

            if ($inputType == 'text_area') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                if ($placeHolder != null) {
                    $placeHolder = 'placeholder="' . $placeHolder . '"';
                } else {
                    $placeHolder = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br><textarea class="' . $fieldclass . '" name="' . $fieldname . '" id="' . $fieldname . '" ' . $placeHolder . '>' . $fieldvalue . '</textarea></div>';
                $item .= '' . $fieldname . ' TEXT  NOT NULL,';
            }

            if ($inputType == 'div') {
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $divcontents = $newArs[$i]["field"]["div"];

                $form .= '<div class="' . $containerclass . '">' . $divcontents . '</div>';

            }

            if ($inputType == 'hidden') {
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];

                $form .= '<input type="hidden" name="' . $fieldname . '" id="' . $fieldname . '" value="' . $fieldvalue . '">';
                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';

            }

            if ($inputType == 'header') {
                $headertype = $newArs[$i]["field"]["headertype"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $lab = $newArs[$i]["field"]["lab"];

                if ($containerclass != null) {
                    $class = 'class="' . $containerclass . '"';
                } else {
                    $class = '';
                }

                $form .= '<' . $headertype . ' ' . $class . '>' . $lab . '</' . $headertype . '>';

            }


            if ($inputType == 'paragraph') {
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $para = $newArs[$i]["field"]["para"];

                if ($containerclass != null) {
                    $class = 'class="' . $containerclass . '"';
                } else {
                    $class = '';
                }

                if ($fieldclass != null) {
                    $paraClass = 'class="' . $fieldclass . '"';
                } else {
                    $paraClass = '';
                }

                $form .= '<div ' . $class . '><p ' . $paraClass . '>' . $para . '</p></div>';

            }

            if ($inputType == 'file_upload') {
                $lab = $newArs[$i]["field"]["lab"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fielddesti = $newArs[$i]["field"]["fielddesti"];

                if ($containerclass != null) {
                    $class = 'class="' . $containerclass . '"';
                } else {
                    $class = '';
                }

                if ($fieldclass != null) {
                    $fieldclass = 'class="' . $fieldclass . '"';
                } else {
                    $fieldclass = '';
                }

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                $form .= '<div ' . $class . '><lable>' . $lab . '</lable><br><input ' . $fieldclass . ' type="file" id="' . $fieldname . '" name="' . $fieldname . '" '.$required.'><input class="upload_desti" type="hidden" name="files_dir" id="files_dir" value="' . $fielddesti . '"></div>';
                $item .= '' . $fieldname . ' TEXT  NOT NULL,';
            }

            if ($inputType == 'button') {
                $buttonclass = $newArs[$i]["field"]["buttonclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $buttonattr = $newArs[$i]["field"]["buttonattr"];
                $lab = $newArs[$i]["field"]["lab"];

                if ($buttonclass != null) {
                    $class = 'class="' . $buttonclass . '"';
                } else {
                    $class = '';
                }

                if ($containerclass != null) {
                    $containclass = 'class="' . $containerclass . '"';
                } else {
                    $containclass = '';
                }

                $form .= '<div ' . $containclass . '><button ' . $class . ' '. $buttonattr .'>' . $lab . '</button></div>';

            }
        }

        include('harness.php');
        ///DROP FORM TABLE AND START FRESH///
        $data->query("DROP TABLE $form_name")or die('Cannot drop form table - '.$form_name);
        $sql = 'CREATE TABLE '.str_replace(' ','_',$form_name).' (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,'.$item.'receive_date INT(100) NOT NULL, active VARCHAR(12) DEFAULT \'true\', status VARCHAR(12) DEFAULT \'new\')';

        //echo $sql;
        $data->query($sql)or die("Cannot create form");

        return $form;

    }
}
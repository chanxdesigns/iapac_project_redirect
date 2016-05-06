<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ProjectLists;

class RedirectController extends Controller
{
    //Make the redirect according to the Project ID and Vendor ID
    public function redirect ($projectid,$vendor,$country = "") {

        //Full Abbreviations Country
        $fcountry = "";
        switch ($country) {
            case "ZH":
                $fcountry = "China";
                break;
            case "JP":
                $fcountry = "Japan";
                break;
            case  "ROK":
                $fcountry = "South Korea";
                break;
            case "PH":
                $fcountry = "Philippines";
                break;
            case "INDO":
                $fcountry = "Indonesia";
                break;
            case "MY":
                $fcountry = "Malaysia";
                break;
            case "VN":
                $fcountry = "Vietnam";
                break;
            case "IN":
                $fcountry = "India";
                break;
            case "TH":
                $fcountry = "Thailand";
                break;
            case "HK":
                $fcountry = "Hong Kong";
                break;
            case "SG":
                $fcountry = "Singapore";
                break;
            case "UAE":
                $fcountry = "UAE";
                break;
        }

        if (!empty($fcountry)) {
            /***
             * Only If Country Is Present
             */
            //Get Survey Link
            $survey_link = "";
            $result = ProjectLists::where("Project ID", "=", $projectid)->where("Vendor", "=", $vendor)->where("Country", "=", $fcountry)->get();
            foreach ($result as $k) {
                $survey_link = $k->{'Survey Link'};
            }

            //Add id to the survey link
            $uid = uniqid().$vendor;
            $urlArray = explode("respid",$survey_link);
            $urlArray[0] = $urlArray[0].$uid;
            $survey_link = implode("",$urlArray);
            return redirect()->away($survey_link);

        } else {
            /**
             * Only If Country is Not Present
             */
            //Get Survey Link
            $survey_link = "";
            $result = ProjectLists::where("Project ID", "=", $projectid)->where("Vendor", "=", $vendor)->get();
            foreach ($result as $k) {
                $survey_link = $k->{'Survey Link'};
            }

            //Add id to the survey link
            $uid = uniqid().$vendor;
            $urlArray = explode("respid",$survey_link);
            $urlArray[0] = $urlArray[0].$uid;
            $survey_link = implode("",$urlArray);
            return redirect()->away($survey_link);
        }
    }
}

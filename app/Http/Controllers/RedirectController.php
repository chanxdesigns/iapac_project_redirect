<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\ProjectLists;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    /**
     * Get City
     */
    protected function getCity() {
        $new_ip = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        return unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$new_ip))["geoplugin_city"];
    }

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
            case "ID":
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
            case "KSA":
                $fcountry = "Saudi Arabia";
                break;
            case "JO":
                $fcountry = "Jordan";
                break;
            case "SA":
                $fcountry = "South Africa";
                break;
            case "AUS":
                $fcountry = "Australia";
                break;
            case "TW":
                $fcountry = "Taiwan";
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

            // Add to db for tracking
            $prestart = DB::table('survey_prestart')->insert(
                ['user_id' => $uid, 'vendor' => $vendor, 'country' => $fcountry, 'city' => $this->getCity(), 'started_on' => Carbon::now()]
            );

            if ($prestart) return redirect()->away($survey_link);

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

            // Add id to the survey link
            $uid = uniqid().$vendor;
            $urlArray = explode("respid",$survey_link);
            $urlArray[0] = $urlArray[0].$uid;
            $survey_link = implode("",$urlArray);

            // Add to db for tracking
            $prestart = DB::table('survey_prestart')->insert(
                ['user_id' => $vendorrespid, 'vendor' => $vendor, 'country' => $fcountry, 'city' => $this->getCity(), 'started_on' => Carbon::now()]
            );

            if ($prestart) return redirect()->away($survey_link);
        }
    }

    //With Vendor ID Redirect
    public function withVendorIdRedirect($projectid, $vendor, $country) {
        //Vendor Resp ID
        $vendorrespid = $_GET['id'];
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
            case "ID":
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
            case "KSA":
                $fcountry = "Saudi Arabia";
                break;
            case "JO":
                $fcountry = "Jordan";
                break;
            case "SA":
                $fcountry = "South Africa";
                break;
            case "AUS":
                $fcountry = "Australia";
                break;
            case "TW":
                $fcountry = "Taiwan";
                break;    
        }

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
        $urlArray = explode("respid",$survey_link);
        $urlArray[0] = $urlArray[0].$vendorrespid;
        $survey_link = implode("",$urlArray);

        // Add to db for tracking
        $prestart = DB::table('survey_prestart')->insert(
            ['user_id' => $vendorrespid, 'project_id' => $projectid, 'vendor' => $vendor, 'country' => $country, 'city' => $this->getCity(), 'started_on' => Carbon::now()]
        );

        // Redirect if successfully inserted to DB
        if ($prestart) return redirect()->away($survey_link);
    }
}

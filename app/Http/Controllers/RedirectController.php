<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ProjectLists;

class RedirectController extends Controller
{
    //Make the redirect according to the Project ID and Vendor ID
    public function redirect ($projectid,$vendor) {
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

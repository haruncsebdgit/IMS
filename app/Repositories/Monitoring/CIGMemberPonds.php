<?php

namespace App\Repositories\Monitoring;

use App\Models\Monitoring\CigMemberDetail;
use Auth;

class CIGMemberPonds implements CIGMemberDetailsInterface
{
    public function saveCIGMemberInfoDetails($inputData, $cigMemberId) 
    {
        //dd($inputData);
        if (!isset($inputData['pond_name_number']) || empty($inputData['pond_name_number'])) {
            return;
        }
        if (isset($inputData['member_details_id']) && !empty($inputData['member_details_id'])) {
            CigMemberDetail::where('cig_member_id', $cigMemberId)
                    ->whereNotIn('id', $inputData['member_details_id'])
                    ->delete();
        }
        
        foreach ($inputData['pond_name_number'] as $key=>$item) {
            $memberDetailsId = $inputData['member_details_id'][$key] ?? null;
            $pondInfo = [
                'cig_member_id' => $cigMemberId,
                'pond_name_number' => $item,
                'water_area' => $inputData['water_area'][$key],
                'used_technology_id' => $inputData['used_technology_id'][$key]
            ];
            if(!empty($memberDetailsId)) {
                $pondInfo['updated_by'] = Auth::id();
                CigMemberDetail::find($memberDetailsId)->update($pondInfo);
            } else {
                $pondInfo['created_by'] = Auth::id();
                CigMemberDetail::create($pondInfo);
            }
        }
    }
    
}

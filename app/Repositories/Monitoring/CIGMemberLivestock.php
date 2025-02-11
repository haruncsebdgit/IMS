<?php

namespace App\Repositories\Monitoring;

use App\Models\Monitoring\CigMemberDetail;
use Auth;

class CIGMemberLivestock implements CIGMemberDetailsInterface
{
    public function saveCIGMemberInfoDetails($inputData, $cigMemberId) 
    {
        if (!isset($inputData['animal_type_id']) || empty($inputData['animal_type_id'])) {
            return;
        }
        if (isset($inputData['member_details_id']) && !empty($inputData['member_details_id'])) {
            CigMemberDetail::where('cig_member_id', $cigMemberId)
                    ->whereNotIn('id', $inputData['member_details_id'])
                    ->delete();
        }
        foreach ($inputData['animal_type_id'] as $key=>$item) {
            $memberDetailsId = $inputData['member_details_id'][$key] ?? null;
            $liveStocks = [
                'cig_member_id' => $cigMemberId,
                'animal_type_id' => $item,
                'breed_type_id' => $inputData['breed_type_id'][$key],
                'number_of_animal' => $inputData['number_of_animal'][$key]
            ];
            if(!empty($memberDetailsId)) {
                $liveStocks['updated_by'] = Auth::id();
                CigMemberDetail::find($memberDetailsId)->update($liveStocks);
            } else {
                $liveStocks['created_by'] = Auth::id();
                CigMemberDetail::create($liveStocks);
            }
        }
    }
    
}

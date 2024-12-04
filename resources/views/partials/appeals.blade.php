<tr class ="appeals" data-id={{$modApplications[$numMod]->id}}>
    <td class="user_avatar">
        <img src={{asset($modApplications[$numMod]->user_path)}} alt="user profile picture" width="40" height="40">
        <a href="#" class="user-link">{{$modApplications[$numMod]->username}}</a>
    </td>
    <td class="text-center trust_level">
        {{$modApplications[$numMod]->trust_level}}
    </td>
    <td class="text-center country">
        <span class="label label-default">{{$modApplications[$numMod]->country}}</span>
    </td>
    <td class="text-center action">
        <button type="button" class="btn sucess accept" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept">
            <i class="fas fa-check-circle"></i>    
        </button>
        <button type="button" class="btn danger refuse" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject">
            <i class="fas fa-times-circle"></i>
        </button>
    </td>
</tr>
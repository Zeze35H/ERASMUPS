<tr class ="mods" data-id={{$allMods[$numMod]->id}}>
    <td>
        <img src={{asset($allMods[$numMod]->user_path)}} alt="user profile picture" width="40" height="40">
        <a href="#" class="user-link">{{$allMods[$numMod]->username}}</a>
    </td>
    <td class="text-center">
        {{$allMods[$numMod]->trust_level}}
    </td>
    <td class="text-center">
        <span class="label label-default">{{$allMods[$numMod]->num_interactions}}</span>
    </td>
    <td class="text-center">
        <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Mod">
            <i class="fas fa-user-times"></i>    
        </button>
        <button type="button" class="btn danger demote" data-bs-toggle="tooltip" data-bs-placement="top" title="Demote Mod">
            <i class="fas fa-times-circle"></i>
        </button>
    </td>
</tr>


<tr class ="report" data-id={{$reports[$numReport]->id}}>
    <td>
       <img src={{asset($reports[$numReport]->reported_user_path)}} alt="user profile picture" width="40" height="40">
       <a href={{url('user/'.$reports[$numReport]->reported_id)}} class="user-link">{{$reports[$numReport]->reported_username}}</a>
       <span class="user-subhead">Trust Level: {{$reports[$numReport]->reported_trust_level}}</span>
    </td>
    <td>
      <img src={{asset($reports[$numReport]->reported_by_user_path)}} alt="user profile picture" width="40" height="40">
      <a href={{url('user/'.$reports[$numReport]->reported_by_id)}} class="user-link">{{$reports[$numReport]->reported_by_username}}</a>
      <span class="user-subhead">Trust Level: {{$reports[$numReport]->reported_by_trust_level}}</span>
   </td>
    <td class="text-center">
        {{$reports[$numReport]->timestamp}}
    </td>
    <td class="text-center">
       <span class="label label-default">{{$reports[$numReport]->status}}</span>
    </td>
    <td class="text-center">
       <a href="{{ url('question/' . $reports[$numReport]->question_id . '/' . $question_titles[$numReport] . '#content_' . $reports[$numReport]->content_id) }}">view content</a>
    </td>
    <td class="text-center">
    <span class="label label-default">{{$reports[$numReport]->reason}}</span>
    </td>
    <td class="text-center">
       <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Author">
          <i class="fas fa-user-times"></i>    
       </button>
       <button type="button" class="btn danger trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Content">
          <i class="fas fa-trash-alt"></i>
       </button>
       <button type="button" class="btn danger ignore" data-bs-toggle="tooltip" data-bs-placement="top" title="Ignore Report">
          <i class="fas fa-times-circle"></i>
       </button>
    </td>
 </tr>
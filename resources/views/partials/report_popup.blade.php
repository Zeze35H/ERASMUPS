<div class="modal fade reportPopUpWindow" id="popup{{$type}}{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-type={{$type}} data-id={{$id}}>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="going_to_report_window" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Why are you reporting this?</h5>
                <a class="close_report_window" data-dismiss="modal"> <i class="fas fa-times"></i> </a>
            </div>
            <form>
                <div class="modal-body">
                    <div><label><input required type="radio" name="report" value="inconv_or_disres"> It's inconvenient/disrespectful</label></div>
                    <div><label><input required type="radio" name="report" value="not_val"> It does not add anything valuable</label></div>
                    <div><label><input required type="radio" name="report" value="other"> Other</label><input type="text" name="reason" placeholder="Reason"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Report</button>
                </div>
            </form>
        </div>
        <div id="report_done_window" class="modal-content" hidden>
            <div class="modal-header">
                <a class="close_report_window" data-dismiss="modal"> <i class="fas fa-times"></i> </a>
            </div>
            <div class="modal-body">
                <p>We will review your report!</p>
                <p>Thank you for your feedback.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Accept</button>
            </div>
        </div>
    </div>
</div>
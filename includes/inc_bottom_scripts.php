<!-- Bottom Scripts -->
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/TweenMax.min.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/xenon-api.js"></script>
<script src="assets/js/xenon-toggles.js"></script>
<script src="assets/js/moment.min.js"></script>

<script src="assets/js/jquery.json.js"></script>

<script src="assets/js/xenon-custom.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/jquery-ui/jquery-ui.min.js"></script>
<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="assets/js/toastr/toastr.min.js"></script>

<script src="assets/js/datepicker/bootstrap-datepicker.js"></script>


<!-- Imported scripts on this page -->
<script src="assets/js/datatables/js/jquery.dataTables.min.js"></script>

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/dataTables.bootstrap.js"></script>


<div class="modal fade" id="modal-delete-data">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;"> Êtes-vous sûr de vouloir supprimer cet enregistrement ?</h4>
            </div>
            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">

                <button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link">Annuler</button>
                <button type="button" class="btn btn-danger" id="delete_link">Supprimer</button>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function show_error(error)
    {
        var opts = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.error(error, opts);
    }

    function IsNumeric(e) {
        var specialKeys = new Array();
        specialKeys.push(8,46); //Backspace
        var keyCode = e.which ? e.which : e.keyCode;
        console.log( keyCode );
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        return ret;
    }

    function post_data(form_values)
    {
        $.ajax({
            type: "POST",
            cache: false,
            url: "app/functions.php" ,
            data: form_values,
            success: function(msg)
            {
                window.location.href = msg;
            }
        });
        return true;
    }

    function delete_info(id)
    {
        $('#modal-delete-data').modal('show', {backdrop: 'static'});
        var values= {
            id:id,
            operation:'delete_product'
        };
        $('#delete_link').click(function()
        {
            post_data(values);
            $('#modal-delete-data').modal('hide');
        });
    }
</script> 
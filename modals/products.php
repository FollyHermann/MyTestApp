<div class="modal fade" id="modal-add-product" data-backdrop="static">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title">Fiche article</h4>
            </div>

            <form id="form-add-product" method="post"
                  action="app/functions.php"
                  enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="operation" id="operation">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="designation"
                                       class="control-label">
                                    Désignation
                                </label>
                                <input type="text"
                                       class="form-control"
                                       name="designation"
                                       id="designation">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="control-label">Prix de vente</label>
                            <input type="text" onkeypress="return IsNumeric(event);" ondrop="return false;"
                                   onpaste="return false;" class="form-control" name="sellprice" id="sellprice">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Prix d'achat</label>
                            <input type="text" onkeypress="return IsNumeric(event);"
                                   ondrop="return false;" onpaste="return false;"
                                   class="form-control"
                                   name="buyprice" id="buyprice">
                        </div>
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label class="control-label">Stock initial</label>
                                <input type="text" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"
                                       class="form-control" name="quantity" id="quantity">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-dm-12" align="center">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                    <img src="" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 200px; max-height: 150px">

                                </div>
                                <div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Selectionner</span>
										<span class="fileinput-exists">Changer</span>
										<input type="file" name="image" id="image" accept="image/*">

									</span>
                                    <a href="#" class="btn btn-orange fileinput-exists"
                                       data-dismiss="fileinput">Enlever</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">
                            Annuler
                        </button>
                        <button type="button" onclick="save_product()"
                                class="btn btn-info">
                            Enregister
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>

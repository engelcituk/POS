<div class="modal fade" id="wizardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="wizard-container">
              <div class="card wizard-card" data-color="rose" id="wizardProfile">
                <form action="#" method="">                    
                    <div class="wizard-navigation">
                        <ul>                            
                            <li>
                                <a href="#account" data-toggle="tab">Account</a>
                            </li>
                            <li>
                                <a href="#address" data-toggle="tab">Address</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        
                        <div class="tab-pane" id="account">
                            <h4 class="info-text"> What are you doing? (checkboxes) </h4>
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="col-sm-4">
                                        <div class="choice" data-toggle="wizard-checkbox">
                                            <input type="checkbox" name="jobb" value="Design">
                                            <div class="icon">
                                                <i class="fa fa-pencil"></i>
                                            </div>
                                            <h6>Design</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="choice" data-toggle="wizard-checkbox">
                                            <input type="checkbox" name="jobb" value="Code">
                                            <div class="icon">
                                                <i class="fa fa-terminal"></i>
                                            </div>
                                            <h6>Code</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="choice" data-toggle="wizard-checkbox">
                                            <input type="checkbox" name="jobb" value="Develop">
                                            <div class="icon">
                                                <i class="fa fa-laptop"></i>
                                            </div>
                                            <h6>Develop</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="address">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="info-text"> Are you living in a nice area? </h4>
                                </div>
                                <div class="col-sm-7 col-sm-offset-1">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Street Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Street No.</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-5 col-sm-offset-1">
                                    <div class="form-group label-floating">
                                        <label class="control-label">City</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Country</label>
                                        <select name="country" class="form-control">
                                            <option disabled="" selected=""></option>
                                            <option value="Afghanistan"> Afghanistan </option>
                                            <option value="Albania"> Albania </option>
                                            <option value="Algeria"> Algeria </option>
                                            <option value="American Samoa"> American Samoa </option>
                                            <option value="Andorra"> Andorra </option>
                                            <option value="Angola"> Angola </option>
                                            <option value="Anguilla"> Anguilla </option>
                                            <option value="Antarctica"> Antarctica </option>
                                            <option value="...">...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-footer">
                        <div class="pull-right">
                            <input type='button' class='btn btn-next btn-fill btn-rose btn-wd' name='next' value='Next' />
                            <input type='button' class='btn btn-finish btn-fill btn-rose btn-wd' name='finish' value='Finish' />
                        </div>
                        <div class="pull-left">
                            <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


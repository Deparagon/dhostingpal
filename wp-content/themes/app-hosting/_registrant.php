  <h4 class="title-top-forms">Registrant Information</h4>
   <div class="row mb-3 ">
                                                <div class="col-sm-12 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_email">Email</label>
                                                        <input type="email" name="registrant_email" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                 
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_firstname">First Name</label>
                                                        <input type="text" name="registrant_firstname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="registrant_lastname">Last Name</label>
                                                        <input type="text" name="registrant_lastname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_address">Address</label>
                                                        <input type="text" name="registrant_address" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                 
                                                  <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_phone">Phone</label>
                                                        <input type="text" name="registrant_phone" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>


                                                
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_city">City </label>
                                                        <input type="text" name="registrant_city" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="registrant_postal_code">Postal Code</label>
                                                        <input type="text" name="registrant_postal_code" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                        <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_province_or_state">State/Province </label>
                                                        <input type="text" name="registrant_province_or_state" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="registrant_id_country">Country</label>
                                                        
                                                        
                                                        <select name="registrant_id_country" class="form-control form-control-lg form-control-solid"> 
                                                            <?php
                                                        if(count($countries) >0):
                                                            foreach($countries as $country): ?>
                                                            <option value="<?php echo $country->id_country; ?>" <?php if($country->name =='Nigeria') {
                                                                echo 'selected';
                                                            } ?>> <?php echo $country->name; ?> </option>

                                                        <?php
                                                            endforeach;
                                                        endif;
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                           <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_company_name">Company Name (optional) </label>
                                                        <input type="text" name="registrant_company_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="registrant_address_name">Give this address a name</label>
                                                        <input type="text" name="registrant_address_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>
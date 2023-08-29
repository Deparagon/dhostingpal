   <div class="row mb-3 ">
                                                <div class="col-sm-12 possible_error_line">
                                                    <h3> Add default billing address</h3>
                                                </div>
                                                 
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="default_firstname">First Name</label>
                                                        <input type="text" name="default_firstname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="default_lastname">Last Name</label>
                                                        <input type="text" name="default_lastname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="default_address">Address</label>
                                                        <input type="text" name="default_address" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>

                                                 <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="default_phone">Phone</label>
                                                        <input type="text" name="default_phone" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="default_city">City </label>
                                                        <input type="text" name="default_city" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="default_postal_code">Postal Code</label>
                                                        <input type="text" name="default_postal_code" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                        <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="default_province_or_state">State/Province </label>
                                                        <input type="text" name="default_province_or_state" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="default_id_country">Country</label>
                                                        
                                                        
                                                        <select name="default_id_country" class="form-control form-control-lg form-control-solid"> 
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
                                                        <label for="default_company_name">Company Name (optional) </label>
                                                        <input type="text" name="default_company_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="default_address_name">Give this address a name</label>
                                                        <input type="text" name="default_address_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>
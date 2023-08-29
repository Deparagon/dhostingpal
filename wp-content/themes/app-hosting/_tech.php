   <h4 class="title-top-forms">Technical Information</h4>
   <div class="row mb-3 ">
                                                <div class="col-sm-12 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="tech_email">Email</label>
                                                        <input type="email" name="tech_email" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                 
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="tech_firstname">First Name</label>
                                                        <input type="text" name="tech_firstname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="tech_lastname">Last Name</label>
                                                        <input type="text" name="tech_lastname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="tech_address">Address</label>
                                                        <input type="text" name="tech_address" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>

                                                 <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="tech_phone">Phone</label>
                                                        <input type="text" name="tech_phone" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="tech_city">City </label>
                                                        <input type="text" name="tech_city" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="tech_postal_code">Postal Code</label>
                                                        <input type="text" name="tech_postal_code" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                        <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="tech_province_or_state">State/Province </label>
                                                        <input type="text" name="tech_province_or_state" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="tech_id_country">Country</label>
                                                        
                                                        
                                                        <select name="tech_id_country" class="form-control form-control-lg form-control-solid"> 
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
                                                        <label for="tech_company_name">Company Name (optional) </label>
                                                        <input type="text" name="tech_company_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="tech_address_name">Give this address a name</label>
                                                        <input type="text" name="tech_address_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>
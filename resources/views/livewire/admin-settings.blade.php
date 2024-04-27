<div>
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a wire:click.prevent='selectTab("general_settings")' class="nav-link {{ $tab == 'general_settings' ? 'active' : ''}}" data-toggle="tab" href="#general_settings" role="tab" aria-selected="true">General settings</a>
            </li>

            <li class="nav-item">
                <a wire:click.prevent='selectTab("logo_favicon")' class="nav-link {{ $tab == 'logo_favicon' ? 'active' : ''}}" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="true">Logo & Favicon</a>
            </li>

            <li class="nav-item">
                <a wire:click.prevent='selectTab("social_networks")' class="nav-link {{ $tab == 'social_networks' ? 'active' : ''}}" data-toggle="tab" href="#social_networks" role="tab" aria-selected="true">Social Networks</a>
            </li>

            <li class="nav-item">
                <a wire:click.prevent='selectTab("payment_methods")' class="nav-link {{ $tab == 'payment_methods' ? 'active' : ''}}" data-toggle="tab" href="#payment_methods" role="tab" aria-selected="false">Payment methods</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade {{ $tab == 'general_settings' ? 'active show' : ''}}" id="general_settings" role="tabpanel">
                <div class="pd-20">
                    <form wire:submit.prevent="updateGeneralSettings()">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Name</b></label>
                                    <input type="text" class="form-control" placeholder="Enter your site name" wire:model.defer='site_name'>
                                    @error('site_name') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Email</b></label>
                                    <input type="text" class="form-control" placeholder="Enter site email" wire:model.defer='site_email'>
                                    @error('site_email') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Phone</b></label>
                                    <input type="text" class="form-control" placeholder="Enter site phone" wire:model.defer='site_phone'>
                                    @error('site_phone') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site meta keywords</b> <small>Separated by comma(a,b,c)</small></label>
                                    <input type="text" class="form-control" placeholder="Enter your site meta keywords." wire:model.defer='site_meta_keywords'>
                                    @error('site_meta_keywords') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Site meta description</label>
                            <textarea name="" id="" cols="4" rows="4" placeholder="Site meta desc..."
                            class="form-control" wire:model.defer='site_meta_description'></textarea>
                            @error('site_meta_description') <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'active show' : ''}}" id="logo_favicon" role="tabpanel">
                <div class="pd-20">
                    -------Logo & Favicon---------
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'social_networks' ? 'active show' : ''}}" id="social_networks" role="tabpanel">
                <div class="pd-20">
                    -----------Social & Network-----------------
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'payment_methods' ? 'active show' : ''}}" id="payment_methods" role="tabpanel">
                <div class="pd-20">
                    -----------Payment Methods-----------------
                </div>
            </div>
        </div>
    </div>
</div>

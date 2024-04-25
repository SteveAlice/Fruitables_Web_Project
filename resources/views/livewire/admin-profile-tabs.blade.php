<div>
    <div class="profile-tab height-100-p">
        <div class="tab height-100-p">
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a wire:click.prevent='selectTab("personal_details")' class="nav-link {{ $tab == 'personal_details' ? 'active' : ''}}" data-toggle="tab" href="#personal_details" role="tab">Presonal details</a>
                </li>
                <li class="nav-item">
                    <a wire:click.prevent='selectTab("update_password")' class="nav-link {{ $tab == 'update_password' ? 'active' : ''}}" data-toggle="tab" href="#update_password" role="tab">Update password</a>
                </li>

            </ul>
            <div class="tab-content">
                <!-- Timeline Tab start -->
                <div class="tab-pane fade {{ $tab == 'personal_details' ? 'active show' : ''}}" id="person_details" role="tabpanel">
                    <div class="pd-20">
                        <form action="" wire:submit.prevent='updateAdminPersonalDetails()'>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" wire:model='name' placeholder="Enter your name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label for="">Email</label>
                                        <input type="text" class="form-control" wire:model='email' placeholder="Enter your email">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label for="">Username</label>
                                        <input type="text" class="form-control" wire:model='username' placeholder="Enter your username">
                                        @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary my-3">Save changes</button>
                        </form>
                    </div>
                </div>
                <!-- Timeline Tab End -->
                <!-- Tasks Tab start -->
                <div class="tab-pane fade {{ $tab == 'update_password' ? 'active show' : ''}}" id="update_password" role="tabpanel">
                    <div class="pd-20 profile-task-wrap">
                        ----- Update Password Here ----------
                    </div>
                </div>
                <!-- Tasks Tab End -->

            </div>
        </div>
    </div>
</div>

<?= $this->extend('auth/template'); ?>

<?= $this->Section('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4"><?= lang('Auth.resetYourPassword') ?></h3>
                </div>
                <div class="card-body">

                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <p><?= lang('Auth.enterCodeEmailPassword') ?></p>

                    <form action="<?= url_to('reset-password') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>" id="token" type="text" name="token" placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>" required />
                                    <label for="token"><?= lang('Auth.token') ?></label>
                                    <div class="invalid-feedback">
                                        <?= session('errors.token') ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="inputEmail" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" />
                                    <label for="inputEmail"><?= lang('Auth.email') ?></label>
                                    <div class="invalid-feedback">
                                        <?= session('errors.email') ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" id="inputPassword" type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off" />
                                    <label for="inputPassword"><?= lang('Auth.password') ?></label>
                                    <div class="invalid-feedback">
                                        <?= session('errors.password') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" id="inputPasswordConfirm" type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off" />
                                    <label for="inputPasswordConfirm"><?= lang('Auth.repeatPassword') ?></label>
                                    <div class="invalid-feedback">
                                        <?= session('errors.pass_confirm') ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.resetPassword') ?></button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


<?= $this->endSection('content'); ?>
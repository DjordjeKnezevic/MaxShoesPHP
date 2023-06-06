<div class="modal fade" id="account-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-light" id="exampleModalToggleLabel">ACCOUNT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                LOGIN OR SIGN UP
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-target="#login-modal" data-bs-toggle="modal">LOGIN</button>
                <button class="btn" data-bs-target="#signup-modal" data-bs-toggle="modal">SIGN UP</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="login-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-light" id="exampleModalToggleLabel2">LOGIN</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <form id="logovanje-forma">
                    <div class="mb-3">
                        <label for="login-user-email" class="form-label">Email/Username</label>
                        <input type="text" class="form-control" id="login-user-email">
                    </div>
                    <div class="mb-3">
                        <label for="log-pass" class="form-label">Password</label>
                        <input type="password" class="form-control" id="log-pass">
                    </div>
                    <button type="submit" class="btn btn-primary" id="loginSubmit">Login</button>
                    <span class="form-text alert alert-danger hide ms-1">This user does not exist
                    </span>
                    <span class="form-text alert alert-success hide ms-1">Successfully logged in
                    </span>
                </form>
                <div class="hide alert alert-info mt-3 d-flex justify-content-between align-items-center processing"
                    id="loginProcess">
                    <p class="d-inline-block">Proccessing request...</p>
                    <img src="Assets/img/loading.gif" alt="loading-img" class="img-fluid mx-2 loading-img">
                </div>
            </div>
            <div class="modal-footer">
                <p class="text-light">Don't have an account?</p>
                <button class="btn" data-bs-target="#signup-modal" data-bs-toggle="modal">SIGN UP</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="signup-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-light" id="exampleModalToggleLabel3">SIGN UP</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="signup-forma">
                    <div class="container-sm">
                        <div class="row">
                            <div class="col-md">
                                <div class="formdown">
                                    <span class="hide alert alert-danger" id="username-error"></span>
                                </div>
                                <div class="formup">
                                    <input type="text" name="signup-username" id="signup-username" class="form-control"
                                        placeholder="Ex. Mark#321">
                                    <label for="signup-username">Username</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="formdown">
                                    <span class="hide alert alert-danger" id="password-error"></span>
                                </div>
                                <div class="formup">
                                    <input type="password" name="signup-password" id="signup-password"
                                        class="form-control" placeholder="Ex. Mfjdl3k#@1dd">
                                    <label for="signup-password">Password</label>
                                </div>
                            </div>
                        </div>
                        <p class="hide">some text</p>
                        <div class="row">
                            <div class="col-md">
                                <div class="formdown">
                                    <span class="hide alert alert-danger" id="firstname-error"></span>
                                </div>
                                <div class="formup">
                                    <input type="text" name="signup-firstname" id="signup-firstname"
                                        class="form-control" placeholder="Ex. Mark">
                                    <label for="signup-firstname">First name</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="formdown">
                                    <span class="hide alert alert-danger" id="lastname-error"></span>
                                </div>
                                <div class="formup">
                                    <input type="text" name="signup-lastname" id="signup-lastname" class="form-control"
                                        placeholder="Ex. Marcus">
                                    <label for="signup-lastname">Last name</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="formdown">
                                    <span class="hide alert alert-danger" id="email-error"></span>
                                </div>
                                <div class="formup">
                                    <input type="email" name="signup-email" id="signup-email" size="24"
                                        class="form-control" placeholder="Ex. markmarcus123@example.com">
                                    <label for="signup-email">Email</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="formdown">
                                    <span class="hide alert alert-danger" id="address-error"></span>
                                </div>
                                <div class="formup">
                                    <input type="text" name="signup-address" id="signup-address" size="25"
                                        class="form-control" placeholder="Ex. Zdravka Celara 16">
                                    <label for="signup-address">Address</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9">
                                <input type="checkbox" class="form-check-input" id="termsAndConditions" />
                                <label class="form-check-label" for="termsAndConditions">I accept the terms and
                                    conditions</label>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary form-control" id="submit-button">Sign
                                    Up</button>
                            </div>
                        </div>
                        <div class="hide alert alert-info mt-3 d-flex justify-content-between align-items-center processing"
                            id="registerProcess">
                            <p class="d-inline-block">Proccessing request...</p>
                            <img src="Assets/img/loading.gif" alt="loading-img" class="img-fluid mx-2 loading-img">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <p class="text-light">Already have an account?</p>
                <button class="btn" data-bs-target="#login-modal" data-bs-toggle="modal">LOGIN</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="error-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel4">Error</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<div class="modal" id="success-modal" aria-hidden="true" aria-labelledby="success-modal-header" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h1 class="modal-title m-3" id="success-modal-header"></h1>
                <div class="hide ms-5" id="success-signup">
                    <div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                            aria-label="Warning:" width="15px" height="15px">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                        <div>
                            Successfully signed up
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close mx-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body alert alert-success">
            </div>
        </div>
    </div>
</div>
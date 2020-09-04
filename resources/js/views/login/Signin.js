import React from 'react'
import Bg from '../../images/bg-01.jpg'
import Logo from '../../images/logo.png'
import Auth from '../../Services/Auth'
import { withRouter } from "react-router";

const Signin = () => {
    return (
        <React.Fragment>
        <div class="limiter">
		<div class="container-login100" style={{backgroundImage: `url(${Bg})`}}>
			<div class="wrap-login100">
				<form class="login100-form validate-form">
					<span class="login100-form-logo">
                        
                        <img src={Logo} alt="logo" style={{width: '120px', height: '120px'}} />
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Sign in
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Username / Email" />
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Password" />
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me" />
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Sign in
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
        </React.Fragment>
    )
}

export default withRouter(Signin)

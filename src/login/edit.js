import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import './editor.scss';

let uniqueIdCounter = 0;

function generateUniqueId() {
	return `boosted-login-${++uniqueIdCounter}`;
}

export default function Edit({ attributes, setAttributes }) {
	const {
		usernameLabel,
		usernamePlaceholder,
		passwordLabel,
		passwordPlaceholder,
		rememberMeLabel,
		loginButtonLabel,
		registerLabel,
		lostPasswordLabel,
		uniqueId
	} = attributes;

	if (!uniqueId) {
		setAttributes({ uniqueId: generateUniqueId() });
	}

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Login Form Settings', 'boosted-front-end-login')}>
					<TextControl
						label={__('Username Label', 'boosted-front-end-login')}
						value={usernameLabel}
						onChange={(value) => setAttributes({ usernameLabel: value })}
					/>
					<TextControl
						label={__('Username Placeholder', 'boosted-front-end-login')}
						value={usernamePlaceholder}
						onChange={(value) => setAttributes({ usernamePlaceholder: value })}
					/>
					<TextControl
						label={__('Password Label', 'boosted-front-end-login')}
						value={passwordLabel}
						onChange={(value) => setAttributes({ passwordLabel: value })}
					/>
					<TextControl
						label={__('Password Placeholder', 'boosted-front-end-login')}
						value={passwordPlaceholder}
						onChange={(value) => setAttributes({ passwordPlaceholder: value })}
					/>
					<TextControl
						label={__('Remember Me Label', 'boosted-front-end-login')}
						value={rememberMeLabel}
						onChange={(value) => setAttributes({ rememberMeLabel: value })}
					/>
					<TextControl
						label={__('Login Button', 'boosted-front-end-login')}
						value={loginButtonLabel}
						onChange={(value) => setAttributes({ loginButtonLabel: value })}
					/>
					<TextControl
						label={__('Register Label', 'boosted-front-end-login')}
						value={registerLabel}
						onChange={(value) => setAttributes({ registerLabel: value })}
					/>
					<TextControl
						label={__('Lost Password Label', 'boosted-front-end-login')}
						value={lostPasswordLabel}
						onChange={(value) => setAttributes({ lostPasswordLabel: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				<form className="boosted-front-end-form" method="post" action="#">
					<p className="boosted-front-end-username">
						<RichText
							tagName="label"
							htmlFor="username"
							value={usernameLabel}
							onChange={(value) => setAttributes({ usernameLabel: value })}
							placeholder={__('Username or Email', 'boosted-front-end-login')}
						/>
						<input className="boosted-front-end-username" type="text" id="username" name="username" required placeholder={usernamePlaceholder} />
					</p>
					<p className="boosted-front-end-username">
						<RichText
							tagName="label"
							htmlFor="password"
							value={passwordLabel}
							onChange={(value) => setAttributes({ passwordLabel: value })}
							placeholder={__('Password', 'boosted-front-end-login')}
						/>
						<input className="boosted-front-end-password" type="password" id="password" name="password" required placeholder={passwordPlaceholder} />
					</p>
					<p className="boosted-front-end-remember">
						<label className="boosted-front-end-remember">
							<input name="remember" type="checkbox" id="rememberme" value="forever" />
							<RichText
								tagName="span"
								value={rememberMeLabel}
								onChange={(value) => setAttributes({ rememberMeLabel: value })}
								placeholder={__('Remember Me', 'boosted-front-end-login')}
							/>
						</label>
					</p>
					<p className="boosted-front-end-submit">
						<input
							type="submit"
							className="boosted-front-end-submit"
							value={loginButtonLabel}
							aria-label={__('Log in to your account', 'boosted-front-end-login')}
							disabled
						/>
					</p>
					<nav className="boosted-front-end-navigation">
						<a className="boosted-front-end-navigation-register" href="#">
							<RichText
								tagName="span"
								value={registerLabel}
								onChange={(value) => setAttributes({ registerLabel: value })}
								placeholder={__('Register', 'boosted-front-end-login')}
							/>
						</a> <span> | </span>
						<a className="boosted-front-end-navigation-lost" href="#">
							<RichText
								tagName="span"
								value={lostPasswordLabel}
								onChange={(value) => setAttributes({ lostPasswordLabel: value })}
								placeholder={__('Lost Password?', 'boosted-front-end-login')}
							/>
						</a>
					</nav>
				</form>
			</div>
		</>
	);
}

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl, ToggleControl } from '@wordpress/components';
import './editor.scss';

let uniqueIdCounter = 0;

function generateUniqueId() {
	return `boosted-registration-${++uniqueIdCounter}`;
}

export default function Edit({ attributes, setAttributes }) {

	const {
		usernameLabel,
		usernamePlaceholder,
		emailLabel,
		emailPlaceholder,
		passwordLabel,
		passwordPlaceholder,
		registerButtonLabel,
		confirmPassword,
		confirmPasswordPlaceholder,
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
						label={__('Email Label', 'boosted-front-end-login')}
						value={emailLabel}
						onChange={(value) => setAttributes({ emailLabel: value })}
					/>
					<TextControl
						label={__('Email Placeholder', 'boosted-front-end-login')}
						value={emailPlaceholder}
						onChange={(value) => setAttributes({ emailPlaceholder: value })}
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
						label={__('Confirm Password Label', 'boosted-front-end-login')}
						value={confirmPassword}
						onChange={(value) => setAttributes({ confirmPassword: value })}
					/>
					<TextControl
						label={__('Confirm Password Placeholder', 'boosted-front-end-login')}
						value={confirmPasswordPlaceholder}
						onChange={(value) => setAttributes({ confirmPasswordPlaceholder: value })}
					/>
					<TextControl
						label={__('Register Button', 'boosted-front-end-login')}
						value={registerButtonLabel}
						onChange={(value) => setAttributes({ registerButtonLabel: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				<form className="boosted-front-end boosted-front-end-login" method="post" action="#">
					<p className="boosted-front-end-username">
						<RichText
							tagName="label"
							htmlFor="username"
							value={usernameLabel}
							onChange={(value) => setAttributes({ usernameLabel: value })}
							placeholder={__('Username', 'boosted-front-end-login')}
						/>
						<input className="boosted-front-end-username-field" type="text" id="username" name="username" required placeholder={usernamePlaceholder} />
					</p>
					<p className="boosted-front-end-email">
						<RichText
							tagName="label"
							htmlFor="user_email"
							value={emailLabel}
							onChange={(value) => setAttributes({ emailLabel: value })}
							placeholder={__('Email', 'boosted-front-end-login')}
						/>
						<input className="boosted-front-end-password-field" type="email" id="user_email" name="user_email" required placeholder={emailPlaceholder} />
					</p>
					<p className="boosted-front-end-password">
						<RichText
							tagName="label"
							htmlFor="user_pass"
							value={passwordLabel}
							onChange={(value) => setAttributes({ passwordLabel: value })}
							placeholder={__('Password', 'boosted-front-end-login')}
						/>
						<input className="boosted-front-end-password-confirm-field" type="email" id="user_pass" name="user_pass" required placeholder={passwordPlaceholder} />
					</p>
					<p className="boosted-front-end-password-confirm">
						<RichText
							tagName="label"
							htmlFor="user_pas_confirm"
							value={confirmPassword}
							onChange={(value) => setAttributes({ confirmPassword: value })}
							placeholder={__('Confirm Password', 'boosted-front-end-login')}
						/>
						<input className="boosted-front-end-password-confirm-field" type="email" id="user_pas_confirm" name="user_pas_confirm" required placeholder={confirmPasswordPlaceholder} />
					</p>
					<p className="boosted-front-end-submit">
						<input
							type="submit"
							className="boosted-front-end-submit-btn"
							value={registerButtonLabel}
							aria-label={__('Register a new account', 'boosted-front-end-login')}
							disabled
						/>
					</p>
				</form>
			</div>
		</>
	);
}

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const {
		lostDescription,
		usernameLabel,
		usernamePlaceholder,
		resetButtonLabel,
	} = attributes;


	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Lost Password Settings', 'boosted-front-end-login')}>
					<TextareaControl
						label={__('Description', 'boosted-front-end-login')}
						value={lostDescription}
						onChange={(value) => setAttributes({ lostDescription: value })}
					/>
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
						label={__('Reset Password Button', 'boosted-front-end-login')}
						value={resetButtonLabel}
						onChange={(value) => setAttributes({ resetButtonLabel: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				<form className="boosted-front-end boosted-front-end-lost-password" method="post" action="#">
					<p className="boosted-front-end-form-lost-description">
						<RichText
							tagName="label"
							htmlFor="lost_description"
							value={lostDescription}
							onChange={(value) => setAttributes({ lostDescription: value })}
							placeholder={__('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'boosted-front-end-login')}
						/>
					</p>
					<p className="boosted-front-end-username">
						<RichText
							tagName="label"
							htmlFor="user_login"
							value={usernameLabel}
							onChange={(value) => setAttributes({ usernameLabel: value })}
							placeholder={__('Username or Email', 'boosted-front-end-login')}
						/>
						<input className="boosted-front-end-username-field" type="text" id="username" name="username" required placeholder={usernamePlaceholder} />
					</p>
					<p class="boosted-front-end-form-submit">
						<input
							type="submit"
							className="boosted-front-end-submit-btn"
							value={resetButtonLabel}
							aria-label={__('Request a password reset', 'boosted-front-end-login')}
							disabled
						/>
					</p>
				</form>
			</div>
		</>
	);
}

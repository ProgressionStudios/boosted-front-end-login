import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	RichText,
} from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	SelectControl,
	ToggleControl,
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';

let uniqueIdCounter = 0;

function generateUniqueId() {
	return `boosted-login-${ ++uniqueIdCounter }`;
}

export default function Edit( { attributes, setAttributes } ) {
	const {
		usernameLabel,
		usernamePlaceholder,
		passwordLabel,
		passwordPlaceholder,
		rememberMeLabel,
		loginButtonLabel,
		registerLabel,
		lostPasswordLabel,
		uniqueId,
		registerDisplay,
		registerLink,
		lostPasswordDisplay,
		lostPasswordLink,
		redirectURL,
	} = attributes;

	if ( ! uniqueId ) {
		setAttributes( { uniqueId: generateUniqueId() } );
	}

	const pages = useSelect( ( select ) => {
		return select( 'core' ).getEntityRecords( 'postType', 'page', {
			per_page: -1,
		} );
	}, [] );

	const pageOptions = [
		{
			label: __( 'Referral Page', 'boosted-front-end-login' ),
			value: 'referral_page',
		},
		...( pages || [] ).map( ( page ) => ( {
			label: page.title.rendered,
			value: page.link,
		} ) ),
	];

	const defaultpageOptions = ( pages || [] ).map( ( page ) => ( {
		label: page.title.rendered,
		value: page.link,
	} ) );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __(
						'Login Form Settings',
						'boosted-front-end-login'
					) }
				>
					<SelectControl
						label={ __(
							'Redirect After Login',
							'boosted-front-end-login'
						) }
						value={ redirectURL || 'referral_page' }
						options={ pageOptions }
						onChange={ ( value ) =>
							setAttributes( { redirectURL: value } )
						}
					/>
					<TextControl
						label={ __(
							'Username Label',
							'boosted-front-end-login'
						) }
						value={ usernameLabel }
						onChange={ ( value ) =>
							setAttributes( { usernameLabel: value } )
						}
					/>
					<TextControl
						label={ __(
							'Username Placeholder',
							'boosted-front-end-login'
						) }
						value={ usernamePlaceholder }
						onChange={ ( value ) =>
							setAttributes( { usernamePlaceholder: value } )
						}
					/>
					<TextControl
						label={ __(
							'Password Label',
							'boosted-front-end-login'
						) }
						value={ passwordLabel }
						onChange={ ( value ) =>
							setAttributes( { passwordLabel: value } )
						}
					/>
					<TextControl
						label={ __(
							'Password Placeholder',
							'boosted-front-end-login'
						) }
						value={ passwordPlaceholder }
						onChange={ ( value ) =>
							setAttributes( { passwordPlaceholder: value } )
						}
					/>
					<TextControl
						label={ __(
							'Remember Me Label',
							'boosted-front-end-login'
						) }
						value={ rememberMeLabel }
						onChange={ ( value ) =>
							setAttributes( { rememberMeLabel: value } )
						}
					/>
					<TextControl
						label={ __(
							'Login Button',
							'boosted-front-end-login'
						) }
						value={ loginButtonLabel }
						onChange={ ( value ) =>
							setAttributes( { loginButtonLabel: value } )
						}
					/>
				</PanelBody>
				<PanelBody
					title={ __(
						'Register & Lost Password Settings',
						'boosted-front-end-login'
					) }
				>
					<TextControl
						label={ __(
							'Register Text',
							'boosted-front-end-login'
						) }
						value={ registerLabel }
						onChange={ ( value ) =>
							setAttributes( { registerLabel: value } )
						}
					/>
					<ToggleControl
						label={ __(
							'Override Register Link',
							'boosted-front-end-login'
						) }
						checked={ registerDisplay }
						onChange={ ( value ) =>
							setAttributes( { registerDisplay: value } )
						}
					/>
					{ registerDisplay && (
						<>
							<SelectControl
								label={ __(
									'Register Link',
									'boosted-front-end-login'
								) }
								value={ registerLink }
								options={ defaultpageOptions }
								onChange={ ( value ) =>
									setAttributes( { registerLink: value } )
								}
							/>
						</>
					) }
					<TextControl
						label={ __(
							'Lost Password Text',
							'boosted-front-end-login'
						) }
						value={ lostPasswordLabel }
						onChange={ ( value ) =>
							setAttributes( { lostPasswordLabel: value } )
						}
					/>
					<ToggleControl
						label={ __(
							'Override Lost Password Link',
							'boosted-front-end-login'
						) }
						checked={ lostPasswordDisplay }
						onChange={ ( value ) =>
							setAttributes( { lostPasswordDisplay: value } )
						}
					/>
					{ lostPasswordDisplay && (
						<>
							<SelectControl
								label={ __(
									'Lost Password Link',
									'boosted-front-end-login'
								) }
								value={ lostPasswordLink }
								options={ defaultpageOptions }
								onChange={ ( value ) =>
									setAttributes( { lostPasswordLink: value } )
								}
							/>
						</>
					) }
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<form
					className="boosted-front-end boosted-front-end-login"
					method="post"
					action="#"
				>
					<p className="boosted-front-end-username">
						<RichText
							tagName="label"
							htmlFor="username"
							value={ usernameLabel }
							onChange={ ( value ) =>
								setAttributes( { usernameLabel: value } )
							}
							placeholder={ __(
								'Username or Email',
								'boosted-front-end-login'
							) }
						/>
						<input
							className="boosted-front-end-username-field"
							type="text"
							id="username"
							name="username"
							required
							placeholder={ usernamePlaceholder }
						/>
					</p>
					<p className="boosted-front-end-password">
						<RichText
							tagName="label"
							htmlFor="password"
							value={ passwordLabel }
							onChange={ ( value ) =>
								setAttributes( { passwordLabel: value } )
							}
							placeholder={ __(
								'Password',
								'boosted-front-end-login'
							) }
						/>
						<input
							className="boosted-front-end-password-field"
							type="password"
							id="password"
							name="password"
							required
							placeholder={ passwordPlaceholder }
						/>
					</p>
					<p className="boosted-front-end-remember">
						<label className="boosted-front-end-remember-field">
							<input
								name="remember"
								type="checkbox"
								id="rememberme"
								value="forever"
							/>
							<RichText
								tagName="span"
								value={ rememberMeLabel }
								onChange={ ( value ) =>
									setAttributes( { rememberMeLabel: value } )
								}
								placeholder={ __(
									'Remember Me',
									'boosted-front-end-login'
								) }
							/>
						</label>
					</p>
					<p className="boosted-front-end-submit">
						<input
							type="submit"
							className="boosted-front-end-submit-btn"
							value={ loginButtonLabel }
							aria-label={ __(
								'Log in to your account',
								'boosted-front-end-login'
							) }
							disabled
						/>
					</p>
					<nav className="boosted-front-end-navigation">
						<a
							className="boosted-front-end-navigation-register"
							href="#"
						>
							<RichText
								tagName="span"
								value={ registerLabel }
								onChange={ ( value ) =>
									setAttributes( { registerLabel: value } )
								}
								placeholder={ __(
									'Register',
									'boosted-front-end-login'
								) }
							/>
						</a>{ ' ' }
						<span> | </span>
						<a
							className="boosted-front-end-navigation-lost"
							href="#"
						>
							<RichText
								tagName="span"
								value={ lostPasswordLabel }
								onChange={ ( value ) =>
									setAttributes( {
										lostPasswordLabel: value,
									} )
								}
								placeholder={ __(
									'Lost Password?',
									'boosted-front-end-login'
								) }
							/>
						</a>
					</nav>
				</form>
			</div>
		</>
	);
}

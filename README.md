# WP-offres-emploi-intranet

## Features
A WordPress plugin.

## Prerequisites
- PHP 8.0
- WordPress 6.0

## Installation
Download the latest WP-offres-emploi-intranet.zip from [releases](https://git.manche.io/wordpress/wp-offres-emploi-intranet/-/releases) and install it via WordPress plugin admin menu.

## Usage
- Clone or fork this project to quickly set up a minimal viable WordPress plugin.
- Customize plugin to your needs.
- Update this plugin template with any WordPress standard plugin practices.

### Shortcode
To display the list of job offers, use the `[shortcode_toutes_les_offres]` shortcode in your WordPress posts or pages.

## Customization
To customize the appearance of the job offers displayed by the plugin, you can use the following IDs and classes in your CSS:

- `#offres`: This div wraps around all displayed job offers.
- `.offre`: Each job offer is encapsulated in a button with the class `.offre`.
    - Within each offer, you'll find the following elements with classes and data attributes to facilitate CSS targeting:
        - `.intitule-offre-emploi-intranet`: The job offer's title.
        - `.date-offre-emploi-intranet`: The publication date of the job offer.
        - `.filiere-offre-emploi-intranet`: The type of job offer (e.g., public or private).

## API Configuration
After installing the plugin, navigate to the WordPress admin dashboard:
1. Go to **Settings** > **WP Offres Emploi**.
2. Enter the URL of the API providing the job offers.
3. Save your changes.

## Support
Open an issue on our GitLab for technical issues.

## Roadmap
Past, last & unreleased changes can be found in the [changelog](CHANGELOG.md)

## Contributing
Let's stay organised : open an issue and discuss with project maintainer before submitting a pull request.

## Authors and acknowledgment
- Coded with care by [Schneider Clément](https://github.com/clementtt1)
- Helped by [William Mead](https://git.manche.io/wmead)

## Translation
Follow standard WordPress plugin localization techniques and submit a pull request.

## License
This plugin is available under the terms of the GNU GPLv3 license. See the [LICENSE](LICENSE) file for a full copy of the license.

## Project status
New & In progress

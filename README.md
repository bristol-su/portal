<p align="center">
  <a href="https://github.com/bristol-su/repo">
    <img src="https://s3.eu-west-2.amazonaws.com/bristol-su-static-bucket/committee-portal/su-logo.jpg" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Bristol SU Portal</h3>

  <p align="center">
    A customisable self-service portal for automating and delivering services online.
    <br />
        <a href="https://docs.bristolsustaging.co.uk"><strong>Demo Site »</strong></a>
    <br />
    <a href="https://docs.bristolsustaging.co.uk"><strong>Explore the docs »</strong></a>
<br />
<br />
    <a href="https://github.com/bristol-su/portal/issues/new?template=bug_report.md">Report Bug</a>
    ·
    <a href="https://github.com/bristol-su/portal/issues/new?template=feature_request.md">Request Feature</a>
  </p>
</p>

<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->

[![Build][build-status-shield]][build-status-url]
[![Code Quality][code-quality-shield]][code-quality-url]
[![Release][release-shield]][release-url]
[![MIT License][license-shield]][license-url]

[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]

<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
* [Getting Started](#getting-started)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)


## About The Project

The portal is a web-based platform for automating and digitising services. It is fully customisable, allowing for any number of different services to be automated, integrated with current or new systems and deployed.

It uses the concept of a module, a couple of pages that allow us to fulfill a specific action such as filling in a form, uploading a file or photo, making a payment etc. By placing these pages in a coherent process, e.g. upload a file then make a payment, we can build out and mostly automate any existing service. We then benefit from the provides service management tools provided by the portal such as tracking progress, managing user access and automated emails. 

For developers, it provides an intuitive framework based on Laravel to create any new modules, allowing you to create new features or integrate with third parties. For example, you may use a CRM to allow users to track their orders. Just create a custom module for the portal to view a users orders, bringing all service delivery to a single place while delegating the business logic to specialised third parties.
Its flexible user management system allows you to continue using current data sources with minimal work.

It also comes with a fully-featured API to control users, services, automations and more. When you set up a new service, a custom API is created to allow you to control all aspects of your services no matter what your requirements. 

## Getting Started

This project is still under heavy development, and is due for release in mid March. Therefore, it should not yet be used in production.

The best way to get started is by [trying out our demo site](https://portal-demo.bristolsustaging.co.uk). Use the credentials

```username: admin@example.com```

```password: admin```

We're working on a docker deployment at the moment. For now, you should:

1. Clone the package: ```git clone https://github.com/bristol-su/portal```
2. Install dependencies: ```composer install && npm install```
3. Setup the .env file: ```cp .env.example .env && nano .env```
    1. The only required environment variables are ```DB_DATABASE```, ```DB_USERNAME``` and ```DB_PASSWORD```
4. Generate app keys: ```php artisan key:generate && php artisan passport:keys```
5. Run the migrations: ```php artisan migrate```
6. Build the assets: ```npm run dev```
7. Serve the site: ```php artisan serve```

You will now be able to register and use the portal. To access the management pages, where you create and manage services, you'll need to run the following command: ```php artisan user:promote``````

Selecting your user and refreshing the page will let you enter the 'Management' account. You can now give yourself the additional permissions in 'Site Permissions'.
 
<!-- ROADMAP -->
## Roadmap

The below is a non-exhaustive list of features that will be worked on in the next couple of months. If you fancy taking one on, just let us know!

- [ ] Testing and documentation
- [ ] Progress tracking frontend for users and roles
- [ ] Make services editable
- [ ] Expand permission controls
- [ ] Full API Validation
- [ ] Allow services to be disabled/enabled
- [ ] Logic Group Management Centre
- [ ] Exporting logic groups
- [ ] Syncronising user data with external applications
- [ ] Allow admins to 'view as' participants
- [ ] Notifications
- [ ] Create more actions
- [ ] Custom CSS Controls
- [ ] Sharing third party connections
- [ ] Control language settings and lang files through UI
- [ ] Creating more modules
- [ ] Improve user management system frontend

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, be inspired, and create. Any contributions you make are **greatly appreciated**.

1. Create an issue to notify us of your planned changes
2. Fork the Project
3. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
4. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
5. Push to the Branch (`git push origin feature/AmazingFeature`)
6. Open a Pull Request to the Development Branch

See `CONTRIBUTING` for more information.

<!-- LICENSE -->
## License

Distributed under the GPL-3.0 License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact

Toby Twigger - [toby.twigger@bristol.ac.uk](mailto:toby.twigger@bristol.ac.uk)

Project Link: [https://github.com/bristol-su/portal](https://github.com/bristol-su/portal)

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[release-shield]: https://img.shields.io/packagist/v/bristol-su/portal?include_prereleases&style=for-the-badge
[release-url]: https://github.com/bristol-su/portal
[build-status-shield]: https://img.shields.io/scrutinizer/build/g/bristol-su/portal/develop?style=for-the-badge
[build-status-url]: https://scrutinizer-ci.com/g/bristol-su/portal/build-status/develop
[downloads-shield]: https://img.shields.io/packagist/dt/bristol-su/portal?style=for-the-badge
[downloads-url]: https://packagist.org/packages/bristol-su/portal
[code-quality-shield]: https://img.shields.io/scrutinizer/quality/g/bristol-su/portal/develop?style=for-the-badge
[code-quality-url]: https://scrutinizer-ci.com/g/bristol-su/portal/?branch=develop
[stars-shield]: https://img.shields.io/github/stars/bristol-su/portal?style=for-the-badge
[stars-url]: https://github.com/bristol-su/portal/stargazers
[issues-shield]: https://img.shields.io/github/issues/bristol-su/portal?style=for-the-badge
[issues-url]: https://github.com/bristol-su/portal/issues
[license-shield]: https://img.shields.io/github/license/bristol-su/portal?style=for-the-badge
[license-url]: https://github.com/bristol-su/portal/blob/develop/LICENCE.md

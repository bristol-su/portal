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
<!-- [![Coverage][coverage-shield]][coverage-url] -->
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
2. Install dependencies: ```composer install```
3. Setup the .env file: ```cp .env.example .env && nano .env```
    1. The only required environment variables are ```DB_DATABASE```, ```DB_USERNAME``` and ```DB_PASSWORD```
4. Generate an app key: ```php artisan key:generate```
4. Run the migrations: ```php artisan migrate```
 
Usually, you will want to use the portal package. If you're building an integration with the portal, run the following command to install.

```sh
composer require bristol-su/portal
```

See our [developer docs](https://docs.bristolsustaging.co.uk/books/module-development) for more information.

<!-- ROADMAP -->
## Roadmap

See the [open issues](https://github.com/bristol-su/portal/issues) for a list of proposed features (and known issues).


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
[build-status-shield]: https://img.shields.io/scrutinizer/build/g/bristol-su/portal/master?style=for-the-badge
[build-status-url]: https://scrutinizer-ci.com/g/bristol-su/portal/build-status/master
[downloads-shield]: https://img.shields.io/packagist/dt/bristol-su/portal?style=for-the-badge
[downloads-url]: https://packagist.org/packages/bristol-su/portal
[code-quality-shield]: https://img.shields.io/scrutinizer/quality/g/bristol-su/portal/master?style=for-the-badge
[code-quality-url]: https://scrutinizer-ci.com/g/bristol-su/portal/?branch=master
[stars-shield]: https://img.shields.io/github/stars/bristol-su/portal?style=for-the-badge
[stars-url]: https://github.com/bristol-su/portal/stargazers
[issues-shield]: https://img.shields.io/github/issues/bristol-su/portal?style=for-the-badge
[issues-url]: https://github.com/bristol-su/portal/issues
[license-shield]: https://img.shields.io/github/license/bristol-su/portal?style=for-the-badge
[license-url]: https://github.com/bristol-su/portal/blob/master/LICENCE.md













# Bristol SU Committee Portal

![Scrutinizer](https://scrutinizer-ci.com/g/bristol-su/committee-portal/badges/quality-score.png?b=master)

## Demo Site
[https://portal-demo.bristolsustaging.co.uk](https://portal-demo.bristolsustaging.co.uk)

## The problem

As an organization, Bristol Student Union provides a huge number of different services to students of Bristol University. These range from help with appeals in regards to the examination process, to booking transport for a trip and managing society finances. Furthermore, since each team operates differently depending on what works best for them, each process can be different from both an end-user point of view and a staff member point of view when compared to any other process.

Faced with the issue of trying to align all processes so students could interact with the Student Union much easier and with less confusion, whilst allowing teams to continue to work in the way they think is best for them, the first (and second) version of the portal (name TBD) was born. This portal specifically handled the 'reaffiliation' process, of which every society (out of the 400 students at the University of Bristol have set up and continue to manage and run with help from the SU) must complete. This process involves submitting various documents, letting us know the committee for the upcoming year, and approving your yearly financial transactions for the last financial year ready for auditing. You can find out more about the 2nd version of the portal [here](https://docs.bristolsustaging.co.uk/books/version-2-walkthrough). 

Being done through email & Google forms, as had been done for years, was an administrative nightmare. Hundreds of emails a day, all with different information, had to be recorded and saved somewhere accessible to all staff members. The first portal handled this by having a set of steps which a student had to complete. These included uploading a constitution and a risk assessment, completing treasurer training etc, and through managing the process through the portal the administration and time taken to reaffiliate, from both a staff and student perspective, more than halved.

However, it quickly became apparent that this portal would need to handle many more processes. As the sole developer at the SU, I thought there must be a better way to provide most services the SU offers through an online portal, without me having to build and deploy every process either from scratch or from a prebuilt framework in which to build the processes.

## The solution

Well, this portal! (again, name TBD. Any ideas?) 

The general idea between the new portal, and what sets it aside from the previous work we or others have done in this field, is the realisation that most processes can be simplified to a core set of building blocks. By this, we mean things like:

- Uploading a file
- Filling in a form
- Completing a quiz
- Making a payment
- Selecting sets of users

If we could just build these core blocks once, anyone could string them together however they wanted, customise each tool to suit the purpose, and deploy to students instantly. And this is exactly what the portal does.

Each 'building block' is a Laravel microservice, usually with only a couple of pages and some logic, integrated into the [Bristol SU Support Package](https://github.com/bristol-su/support) which provides the functionality to take your Laravel app and put it beside multiple other apps to make a process. Through controlling access to different processes, we are providing a fully featured, customisable administrative portal, to suit any processes/ways of working a student union (or any other organisation) may have, all open sourced and free!

This is still a work in progress, although the portal is starting to take shape, and so any help would be appreciated in getting this project to a deployable standard. Similarly, if you think you or your organisation may be able to use the portal, we'd love to hear from you and keep in touch! If you have any ideas, feature requests or questions, pop me an email at [toby.twigger@bristol.ac.uk](mailto:toby.twigger@bristol.ac.uk)), or if you're interested in using the portal and want us to keep in touch, simply fill out [this form](https://www.bristolsu.org.uk/portalinterest) (all fields are optional, and we'll only contact you with major updates around the portal).

## Installation

- Clone the project
- Install dependencies (```composer install && npm install```)
- Edit the .env.example file to connect to a database and serve

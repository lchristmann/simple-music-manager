# Simple Music Manager <!-- omit in toc -->

A self-hosted web app that allows any number of amateur or professional musicians to manage their music for any instrument
in an intuitive backend while browsing it in an appealing frontend.

Private. Secure. Stylish.

The setup is quick and easy: just follow the **[Installation Guide](docs/INSTALLATION-GUIDE.md)**.

## Textual Description of the Application

In the backend, you can manage:

- instruments
- collections of pieces (for each instrument)
- compilations of pieces (comparable to playlists on streaming services)

In the frontend, you have:

- a navigation to switch between the instruments and the compilation tab
- on each of those pages, you have your listed collections/compilations
- and can click on each piece contained in them to view their details

The application is multi-tenant by user (each user only sees their own data).

## Technical Architecture

The app uses:

- a [Docker Compose](https://docs.docker.com/compose/) setup based on the [official Docker+Laravel setup example](https://docs.docker.com/guides/frameworks/laravel/)
- [Laravel](https://laravel.com/) 12 on [PHP](https://www.php.net/) 8.4
- [Filament](https://filamentphp.com/) 4 for the backend
- [Livewire](https://livewire.laravel.com/) 3, [Flux UI](https://fluxui.dev/) 2 and  [Tailwind CSS](https://tailwindcss.com/) 4 for the frontend

## Maintenance

This project is actively maintained by [me](https://github.com/lchristmann).

For questions or support, just [email me](mailto:hello@lchristmann.com).

## Contribution

See the [Contribution Guide](docs/CONTRIBUTION-GUIDE.md) and the [Developer Docs](DEVELOPER-DOCS.md).

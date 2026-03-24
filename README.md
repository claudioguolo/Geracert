# GERACERT Repository

GERACERT is an open-source system for managing and publishing ham radio contest certificates.

The project allows radio clubs, contest organizers and individual radio amateurs to:

- register certificate records in a database
- manage certificate templates visually
- import participant data in batch using CSV
- publish a public search page by callsign or club
- generate PDF certificates on demand

The goal of this project is to offer a reusable starting point so that other ham radio communities do not need to build a certificate management platform from scratch.

Contributions are welcome. If you use GERACERT in your club, event or personal project, consider opening issues, submitting improvements and sharing adaptations that may also help other radio amateurs.

This repository is organized in two main directories on purpose:

- [`py9mt/`](py9mt/): public web root
- [`geracert/`](geracert/): CodeIgniter 4 application

This split exists to support shared hosting environments such as Hostinger, where the full application should not live inside `public_html`.

## Where to Start

Project documentation:

- [Full application README](geracert/README.md)
- [Certificate template guide](geracert/docs/CERTIFICATE_TEMPLATES.md)
- [License](LICENSE)
- [Changelog](CHANGELOG.md)

Common commands:

```bash
cp .env.example .env
./scripts/setup
./scripts/migrate
./scripts/seed
./scripts/test
```

## Directory Summary

```text
.
├── docker-compose.yaml
├── docker/              # Docker images and local stack
├── py9mt/               # Public entrypoint / web root
├── geracert/            # Main CI4 application
└── scripts/             # Convenience commands for contributors
```

For installation, usage, deployment and customization details, see the full [application README](geracert/README.md).

## Community Files

- [Contributing Guide](CONTRIBUTING.md)
- [Security Policy](SECURITY.md)
- [Changelog](CHANGELOG.md)

# GERACERT Repository

This repository is organized in two main directories on purpose:

- [`py9mt/`](/home/claudio/docker/geracert/py9mt): public web root
- [`geracert/`](/home/claudio/docker/geracert/geracert): CodeIgniter 4 application

This split exists to support shared hosting environments such as Hostinger, where the full application should not live inside `public_html`.

## Where to Start

Project documentation:

- [Full application README](/home/claudio/docker/geracert/geracert/README.md)
- [Certificate template guide](/home/claudio/docker/geracert/geracert/docs/CERTIFICATE_TEMPLATES.md)
- [License](/home/claudio/docker/geracert/LICENSE)
- [Changelog](/home/claudio/docker/geracert/CHANGELOG.md)

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

For installation, usage, deployment and customization details, see the full [application README](/home/claudio/docker/geracert/geracert/README.md).

## Community Files

- [Contributing Guide](/home/claudio/docker/geracert/CONTRIBUTING.md)
- [Security Policy](/home/claudio/docker/geracert/SECURITY.md)
- [Changelog](/home/claudio/docker/geracert/CHANGELOG.md)

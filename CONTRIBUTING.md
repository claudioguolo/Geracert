# Contributing

Thank you for considering contributing to GERACERT.

## Development Setup

From the repository root:

```bash
cp .env.example .env
docker compose up -d --build
./scripts/migrate
./scripts/seed
./scripts/test
```

Application entrypoints:

- public app: `http://localhost:8085`
- CodeIgniter app code: `geracert/`
- public web root: `py9mt/`

## Contribution Guidelines

- Keep changes focused and easy to review.
- Preserve the shared-hosting layout with `py9mt/` as the public web root.
- Prefer CodeIgniter 4 conventions already used in the project.
- Add or update automated tests when changing behavior.
- Do not commit secrets, dumps, generated PDFs, uploaded images or local `.env` files.

## Suggested Workflow

1. Fork the repository.
2. Create a branch for your change.
3. Run the test suite.
4. Open a pull request with a clear summary and screenshots when UI is affected.

## Pull Request Checklist

- Code builds and runs locally.
- Tests pass.
- Documentation was updated when needed.
- No secrets or local artifacts were added.

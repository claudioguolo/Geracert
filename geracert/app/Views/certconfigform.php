<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<?php
$certconfig = $certconfig ?? null;
$mode = $mode ?? 'create';
$contestImageFiles = $contestImageFiles ?? [];
$fieldValue = static function (string $field) use ($certconfig): string {
    $oldValue = old($field);
    if ($oldValue !== null) {
        return (string) $oldValue;
    }

    if ($field === 'imagem') {
        $uploadedImage = session()->getFlashdata('uploaded_image');
        if ($uploadedImage !== null) {
            return (string) $uploadedImage;
        }
    }

    return isset($certconfig->{$field}) ? (string) $certconfig->{$field} : '';
};
$colorValue = static function (string $field) use ($fieldValue): string {
    $style = $fieldValue($field);

    if (! preg_match('/(?:^|;)\s*color\s*:\s*([^;]+)/i', $style, $matches)) {
        return '#000000';
    }

    $rawColor = strtolower(trim($matches[1]));
    $namedColors = [
        'black' => '#000000',
        'white' => '#ffffff',
        'gray' => '#808080',
        'grey' => '#808080',
        'red' => '#ff0000',
        'green' => '#008000',
        'blue' => '#0000ff',
        'yellow' => '#ffff00',
    ];

    if (isset($namedColors[$rawColor])) {
        return $namedColors[$rawColor];
    }

    if (preg_match('/^#([a-f0-9]{3}|[a-f0-9]{6})$/i', $rawColor) === 1) {
        if (strlen($rawColor) === 4) {
            return sprintf(
                '#%1$s%1$s%2$s%2$s%3$s%3$s',
                $rawColor[1],
                $rawColor[2],
                $rawColor[3]
            );
        }

        return $rawColor;
    }

    return '#000000';
};
$fontSizeValue = static function (string $field) use ($fieldValue): string {
    $style = $fieldValue($field);

    if (! preg_match('/(?:^|;)\s*font-size\s*:\s*([0-9]+(?:\.[0-9]+)?)px/i', $style, $matches)) {
        return '';
    }

    return trim($matches[1]);
};
$sampleValues = [
    '$id' => '1001',
    '$indicativo' => 'PY9MT',
    '$indicativo-' => '- PY9MT -',
    '$nome+indicativo' => 'Claudio - PY9MT -',
    '$concurso' => 'CQWS',
    '$pontuacao' => '15420',
    '$ano' => '2026',
    '$cod_clube' => '001',
    '$tipo_evento' => 'HF',
    '$organizador' => 'GERACERT',
    '$modalidade' => 'CW',
    '$categoria' => 'SINGLE-OP',
    '$class_geral' => '1st Place',
    '$status' => 'd',
    '$operador' => 'Claudio PY9MT',
    '$km' => '0',
    '$class_pais' => '1',
    '$class_cont' => '1',
    '$clube' => 'LABRE',
    '$nome' => 'Claudio',
];
?>

<div class="container mt-5">

    <?php if (! empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($uploadError = session()->getFlashdata('upload_error')) : ?>
        <div class="alert alert-danger"><?= esc($uploadError) ?></div>
    <?php endif; ?>

    <?php if ($uploadSuccess = session()->getFlashdata('upload_success')) : ?>
        <div class="alert alert-success"><?= esc($uploadSuccess) ?></div>
    <?php endif; ?>

    <?php echo form_open_multipart('certconfig/store') ?>
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="concurso" class="form-label"><?= esc(lang('UI.tableContest')) ?></label>
                            <input type="text" name="concurso" id="concurso" class="form-control" value="<?= esc($fieldValue('concurso')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="ano" class="form-label"><?= esc(lang('UI.year')) ?></label>
                            <input type="text" name="ano" id="ano" class="form-control" value="<?= esc($fieldValue('ano')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="organizador" class="form-label"><?= esc(lang('UI.organizer')) ?></label>
                            <input type="text" name="organizador" id="organizador" class="form-control" value="<?= esc($fieldValue('organizador')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="imagem" class="form-label"><?= esc(lang('UI.image')) ?></label>
                            <input type="text" name="imagem" id="imagem" class="form-control" list="contest-image-files" value="<?= esc($fieldValue('imagem')) ?>">
                            <datalist id="contest-image-files">
                                <?php foreach ($contestImageFiles as $imageFile) : ?>
                                    <option value="<?= esc($imageFile) ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                            <div class="form-text"><?= esc(lang('UI.imageFileHelp')) ?></div>
                            <?php if ($contestImageFiles !== []) : ?>
                                <div class="form-text"><?= esc(lang('UI.imageFileList')) ?>: <?= esc(implode(', ', $contestImageFiles)) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                            <div class="card border-light-subtle bg-light">
                                <div class="card-body">
                                    <label for="background_image" class="form-label"><?= esc(lang('UI.selectImageFile')) ?></label>
                                    <input type="file" name="background_image" id="background_image" class="form-control" accept=".png,.jpg,.jpeg,image/png,image/jpeg">
                                    <div class="form-text mb-3"><?= esc(lang('UI.imageUploadCriteria')) ?></div>
                                    <button
                                        type="submit"
                                        class="btn btn-outline-secondary"
                                        formaction="<?= esc(base_url('certconfig/upload-image')) ?>"
                                        formmethod="post"
                                    >
                                        <?= esc(lang('UI.imageUploadButton')) ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php if ($contestImageFiles !== []) : ?>
                            <div class="col-12">
                                <label class="form-label d-block"><?= esc(lang('UI.imageGallery')) ?></label>
                                <div class="form-text mb-2"><?= esc(lang('UI.clickToUseImage')) ?></div>
                                <div class="gc-image-gallery">
                                    <?php foreach ($contestImageFiles as $imageFile) : ?>
                                        <button
                                            type="button"
                                            class="gc-image-option"
                                            data-image-file="<?= esc($imageFile) ?>"
                                            aria-label="<?= esc($imageFile) ?>"
                                        >
                                            <img src="<?= esc(base_url('images/contest/' . rawurlencode($imageFile))) ?>" alt="<?= esc($imageFile) ?>">
                                            <span><?= esc($imageFile) ?></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-12">
                            <label for="html" class="form-label"><?= esc(lang('UI.bodyHtml')) ?></label>
                            <textarea name="html" id="html" class="form-control" rows="8"><?= esc($fieldValue('html')) ?></textarea>
                            <div class="form-text"><?= nl2br(esc(lang('UI.templateHtmlHelp'))) ?></div>
                        </div>
                        <div class="col-12">
                            <label for="texto_text" class="form-label"><?= esc(lang('UI.bodyStyle')) ?></label>
                            <div class="input-group">
                                <input type="text" name="texto_text" id="texto_text" class="form-control" value="<?= esc($fieldValue('texto_text')) ?>">
                                <input type="color" class="form-control form-control-color gc-color-input" data-style-color-for="texto_text" value="<?= esc($colorValue('texto_text')) ?>" title="<?= esc(lang('UI.textColor')) ?>" aria-label="<?= esc(lang('UI.textColor')) ?>">
                                <input type="number" min="1" step="1" class="form-control gc-size-input" data-style-size-for="texto_text" value="<?= esc($fontSizeValue('texto_text')) ?>" title="<?= esc(lang('UI.textSize')) ?>" aria-label="<?= esc(lang('UI.textSize')) ?>" placeholder="px">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="serial_text" class="form-label"><?= esc(lang('UI.serialStyle')) ?></label>
                            <div class="input-group">
                                <input type="text" name="serial_text" id="serial_text" class="form-control" value="<?= esc($fieldValue('serial_text')) ?>">
                                <input type="color" class="form-control form-control-color gc-color-input" data-style-color-for="serial_text" value="<?= esc($colorValue('serial_text')) ?>" title="<?= esc(lang('UI.textColor')) ?>" aria-label="<?= esc(lang('UI.textColor')) ?>">
                                <input type="number" min="1" step="1" class="form-control gc-size-input" data-style-size-for="serial_text" value="<?= esc($fontSizeValue('serial_text')) ?>" title="<?= esc(lang('UI.textSize')) ?>" aria-label="<?= esc(lang('UI.textSize')) ?>" placeholder="px">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="datetime_text" class="form-label"><?= esc(lang('UI.dateTimeStyle')) ?></label>
                            <div class="input-group">
                                <input type="text" name="datetime_text" id="datetime_text" class="form-control" value="<?= esc($fieldValue('datetime_text')) ?>">
                                <input type="color" class="form-control form-control-color gc-color-input" data-style-color-for="datetime_text" value="<?= esc($colorValue('datetime_text')) ?>" title="<?= esc(lang('UI.textColor')) ?>" aria-label="<?= esc(lang('UI.textColor')) ?>">
                                <input type="number" min="1" step="1" class="form-control gc-size-input" data-style-size-for="datetime_text" value="<?= esc($fontSizeValue('datetime_text')) ?>" title="<?= esc(lang('UI.textSize')) ?>" aria-label="<?= esc(lang('UI.textSize')) ?>" placeholder="px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h2 class="h5 mb-3"><?= esc(lang('UI.headingStyle')) ?></h2>
                    <div class="row g-3">
                        <?php for ($i = 1; $i <= 6; $i++) : ?>
                            <div class="col-md-6">
                                <label for="size_h<?= $i ?>" class="form-label">H<?= $i ?></label>
                                <div class="input-group">
                                    <input type="text" name="size_h<?= $i ?>" id="size_h<?= $i ?>" class="form-control" value="<?= esc($fieldValue('size_h' . $i)) ?>">
                                    <input type="color" class="form-control form-control-color gc-color-input" data-style-color-for="size_h<?= $i ?>" value="<?= esc($colorValue('size_h' . $i)) ?>" title="<?= esc(lang('UI.textColor')) ?>" aria-label="<?= esc(lang('UI.textColor')) ?>">
                                    <input type="number" min="1" step="1" class="form-control gc-size-input" data-style-size-for="size_h<?= $i ?>" value="<?= esc($fontSizeValue('size_h' . $i)) ?>" title="<?= esc(lang('UI.textSize')) ?>" aria-label="<?= esc(lang('UI.textSize')) ?>" placeholder="px">
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card border-0 shadow-sm sticky-top" style="top: 1rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h2 class="h5 mb-1"><?= esc(lang('UI.visualEditor')) ?></h2>
                            <p class="text-muted small mb-0"><?= esc(lang('UI.visualEditorHelp')) ?></p>
                        </div>
                        <span class="badge text-bg-light"><?= esc(lang('UI.previewSampleData')) ?></span>
                    </div>

                    <div class="alert alert-secondary small py-2 mb-3">
                        <strong><?= esc(lang('UI.livePreview')) ?>:</strong>
                        <?= esc(lang('UI.previewBodyBlock')) ?>, <?= esc(lang('UI.previewSerialBlock')) ?>, <?= esc(lang('UI.previewDateBlock')) ?>
                        <br>
                        <?= esc(lang('UI.resizeHint')) ?>
                    </div>

                    <div class="gc-preview-shell">
                        <iframe id="gc-preview-frame" class="gc-preview-frame" title="<?= esc(lang('UI.livePreview')) ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <input type="submit" value="<?= esc(lang('UI.save')) ?>" class="btn btn-primary">
        <input
            type="hidden"
            name="id"
            value="<?= $mode === 'edit' && isset($certconfig->id) ? esc((string) $certconfig->id) : '' ?>"
        >
    </div>
    <?php echo form_close() ?>

</div>

<style>
    .gc-preview-shell {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .gc-preview-frame {
        width: 1123px;
        height: 794px;
        border: 1px solid #d0d7de;
        border-radius: 1rem;
        background: #fff;
        transform-origin: top left;
    }

    .gc-image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 0.75rem;
        max-height: 260px;
        overflow-y: auto;
        padding: 0.25rem;
        border: 1px solid #e9ecef;
        border-radius: 0.75rem;
        background: #f8f9fa;
    }

    .gc-image-option {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        border: 1px solid #d0d7de;
        border-radius: 0.75rem;
        background: #fff;
        padding: 0.4rem;
        text-align: left;
        transition: border-color 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
    }

    .gc-image-option:hover,
    .gc-image-option.is-active {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
        transform: translateY(-1px);
    }

    .gc-image-option img {
        width: 100%;
        aspect-ratio: 1.414 / 1;
        object-fit: cover;
        border-radius: 0.5rem;
        background: #eef2f7;
    }

    .gc-image-option span {
        font-size: 0.75rem;
        line-height: 1.25;
        word-break: break-word;
    }

    .gc-color-input {
        max-width: 3.5rem;
        padding: 0.25rem;
        cursor: pointer;
    }

    .gc-size-input {
        max-width: 5.5rem;
    }
</style>

<script>
(() => {
    const form = document.querySelector('form[action$="certconfig/store"]');
    const frame = document.getElementById('gc-preview-frame');

    if (!form || !frame) {
        return;
    }

    const previewUrl = '<?= esc(base_url('certconfig/preview')) ?>';
    const shell = document.querySelector('.gc-preview-shell');
    const imageInput = document.getElementById('imagem');
    const imageOptions = Array.from(document.querySelectorAll('.gc-image-option'));
    const naturalSize = {
        width: 1123,
        height: 794,
    };
    const styleInputs = {
        body: document.getElementById('texto_text'),
        serial: document.getElementById('serial_text'),
        datetime: document.getElementById('datetime_text'),
    };
    const colorInputs = Array.from(document.querySelectorAll('.gc-color-input'));
    const sizeInputs = Array.from(document.querySelectorAll('.gc-size-input'));
    let renderTimer = null;
    let dragCleanup = null;

    const parseDeclarations = (value) => {
        const declarations = {};
        String(value || '').split(';').forEach((part) => {
            const [property, ...rest] = part.split(':');
            if (!property || rest.length === 0) {
                return;
            }
            declarations[property.trim().toLowerCase()] = rest.join(':').trim();
        });
        return declarations;
    };

    const stringifyDeclarations = (declarations) => Object.entries(declarations)
        .filter(([, value]) => value !== undefined && value !== null && String(value).trim() !== '')
        .map(([property, value]) => `${property}: ${value}`)
        .join('; ') + (Object.keys(declarations).length ? ';' : '');

    const colorToHex = (value) => {
        if (!value) {
            return null;
        }

        const sample = document.createElement('span');
        sample.style.color = '';
        sample.style.color = value;

        if (!sample.style.color) {
            return null;
        }

        sample.style.display = 'none';
        document.body.appendChild(sample);
        const resolved = getComputedStyle(sample).color;
        sample.remove();

        const matches = resolved.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
        if (!matches) {
            return null;
        }

        return `#${[matches[1], matches[2], matches[3]]
            .map((part) => Number(part).toString(16).padStart(2, '0'))
            .join('')}`;
    };

    const syncColorPickerFromInput = (input) => {
        if (!input || !input.id) {
            return;
        }

        const picker = document.querySelector(`[data-style-color-for="${input.id}"]`);
        if (!(picker instanceof HTMLInputElement)) {
            return;
        }

        const declarations = parseDeclarations(input.value);
        const resolved = colorToHex(declarations.color || '');
        picker.value = resolved || '#000000';
    };

    const syncInputColorFromPicker = (picker) => {
        const targetId = picker.dataset.styleColorFor || '';
        const input = document.getElementById(targetId);

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        const declarations = parseDeclarations(input.value);
        declarations.color = picker.value;
        input.value = stringifyDeclarations(declarations);
    };

    const syncSizeInputFromStyle = (input) => {
        if (!input || !input.id) {
            return;
        }

        const sizeControl = document.querySelector(`[data-style-size-for="${input.id}"]`);
        if (!(sizeControl instanceof HTMLInputElement)) {
            return;
        }

        const declarations = parseDeclarations(input.value);
        const match = String(declarations['font-size'] || '').match(/^([0-9]+(?:\.[0-9]+)?)px$/i);
        sizeControl.value = match ? match[1] : '';
    };

    const syncInputSizeFromControl = (control) => {
        const targetId = control.dataset.styleSizeFor || '';
        const input = document.getElementById(targetId);

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        const declarations = parseDeclarations(input.value);
        const size = String(control.value || '').trim();

        if (size === '') {
            delete declarations['font-size'];
        } else {
            declarations['font-size'] = `${size}px`;
        }

        input.value = stringifyDeclarations(declarations);
    };

    const attachDrag = (selector, input) => {
        const doc = frame.contentDocument;
        const element = doc.querySelector(selector);

        if (!element) {
            return () => {};
        }

        element.style.outline = '2px dashed rgba(13, 110, 253, 0.65)';
        element.style.cursor = 'move';

        const handle = doc.createElement('div');
        handle.textContent = selector === '.texto'
            ? '<?= esc(lang('UI.previewBodyBlock')) ?>'
            : (selector === '.serial' ? '<?= esc(lang('UI.previewSerialBlock')) ?>' : '<?= esc(lang('UI.previewDateBlock')) ?>');
        handle.style.position = 'absolute';
        handle.style.top = '0';
        handle.style.left = '0';
        handle.style.padding = '2px 6px';
        handle.style.fontSize = '11px';
        handle.style.fontWeight = '700';
        handle.style.color = '#fff';
        handle.style.background = '#0d6efd';
        handle.style.zIndex = '9999';
        handle.style.borderRadius = '0 0 8px 0';
        element.prepend(handle);

        const resizeHandle = doc.createElement('div');
        resizeHandle.style.position = 'absolute';
        resizeHandle.style.right = '0';
        resizeHandle.style.bottom = '0';
        resizeHandle.style.width = '16px';
        resizeHandle.style.height = '16px';
        resizeHandle.style.background = '#0d6efd';
        resizeHandle.style.borderRadius = '6px 0 0 0';
        resizeHandle.style.cursor = 'nwse-resize';
        resizeHandle.style.zIndex = '9999';
        element.appendChild(resizeHandle);

        let dragging = false;
        let resizing = false;
        let startX = 0;
        let startY = 0;
        let initialLeft = 0;
        let initialTop = 0;
        let initialWidth = 0;
        let initialHeight = 0;

        const down = (event) => {
            if (event.target === resizeHandle) {
                return;
            }

            dragging = true;
            startX = event.clientX;
            startY = event.clientY;
            initialLeft = element.offsetLeft;
            initialTop = element.offsetTop;
            event.preventDefault();
        };

        const downResize = (event) => {
            resizing = true;
            startX = event.clientX;
            startY = event.clientY;
            initialWidth = element.offsetWidth;
            initialHeight = element.offsetHeight;
            event.preventDefault();
            event.stopPropagation();
        };

        const move = (event) => {
            if (resizing) {
                const nextWidth = Math.max(80, initialWidth + (event.clientX - startX));
                const nextHeight = Math.max(50, initialHeight + (event.clientY - startY));
                const snappedWidth = Math.round(nextWidth / 10) * 10;
                const snappedHeight = Math.round(nextHeight / 10) * 10;

                element.style.width = `${snappedWidth}px`;
                element.style.height = `${snappedHeight}px`;
                return;
            }

            if (!dragging) {
                return;
            }

            const nextLeft = Math.max(0, initialLeft + (event.clientX - startX));
            const nextTop = Math.max(0, initialTop + (event.clientY - startY));
            const snappedLeft = Math.round(nextLeft / 10) * 10;
            const snappedTop = Math.round(nextTop / 10) * 10;

            element.style.left = `${snappedLeft}px`;
            element.style.top = `${snappedTop}px`;
            element.style.right = 'auto';
            element.style.bottom = 'auto';
        };

        const up = () => {
            if (resizing) {
                resizing = false;

                const declarations = parseDeclarations(input.value);
                declarations.width = `${Math.round(element.offsetWidth)}px`;
                declarations.height = `${Math.round(element.offsetHeight)}px`;
                input.value = stringifyDeclarations(declarations);
            }

            if (!dragging) {
                return;
            }

            dragging = false;

            const declarations = parseDeclarations(input.value);
            declarations.position = 'fixed';
            declarations.left = `${Math.round(element.offsetLeft)}px`;
            declarations.top = `${Math.round(element.offsetTop)}px`;
            delete declarations.right;
            delete declarations.bottom;
            input.value = stringifyDeclarations(declarations);
        };

        element.addEventListener('mousedown', down);
        resizeHandle.addEventListener('mousedown', downResize);
        doc.addEventListener('mousemove', move);
        doc.addEventListener('mouseup', up);

        return () => {
            element.removeEventListener('mousedown', down);
            resizeHandle.removeEventListener('mousedown', downResize);
            doc.removeEventListener('mousemove', move);
            doc.removeEventListener('mouseup', up);
        };
    };

    const enhancePreview = () => {
        if (dragCleanup) {
            dragCleanup();
        }

        const cleanups = [
            attachDrag('.texto', styleInputs.body),
            attachDrag('.serial', styleInputs.serial),
            attachDrag('.datetime', styleInputs.datetime),
        ];

        dragCleanup = () => {
            cleanups.forEach((cleanup) => cleanup());
        };
    };

    const renderPreview = async () => {
        const formData = new FormData(form);

        try {
            const response = await fetch(previewUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const html = await response.text();
            frame.srcdoc = html;
        } catch (error) {
            frame.srcdoc = '<p style="padding: 1rem; font-family: sans-serif;">Preview unavailable.</p>';
        }
    };

    const resizeFrame = () => {
        if (!shell) {
            return;
        }

        const scale = Math.min(1, shell.clientWidth / naturalSize.width);
        frame.style.width = `${naturalSize.width}px`;
        frame.style.height = `${naturalSize.height}px`;
        frame.style.transform = `scale(${scale})`;
        shell.style.height = `${Math.round(naturalSize.height * scale)}px`;
    };

    const schedulePreview = () => {
        clearTimeout(renderTimer);
        renderTimer = setTimeout(renderPreview, 180);
    };

    const syncSelectedImage = () => {
        const current = (imageInput.value || '').trim();
        imageOptions.forEach((button) => {
            button.classList.toggle('is-active', button.dataset.imageFile === current);
        });
    };

    frame.addEventListener('load', () => {
        try {
            enhancePreview();
        } catch (error) {
            // Ignore preview helper failures and keep the raw preview available.
        }
    });

    Array.from(form.elements).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        const eventName = element.tagName === 'TEXTAREA' || element.tagName === 'INPUT' ? 'input' : 'change';
        element.addEventListener(eventName, () => {
            if (element instanceof HTMLInputElement) {
                syncColorPickerFromInput(element);
                syncSizeInputFromStyle(element);
            }

            schedulePreview();
        });
        if (eventName !== 'change') {
            element.addEventListener('change', () => {
                if (element instanceof HTMLInputElement) {
                    syncColorPickerFromInput(element);
                    syncSizeInputFromStyle(element);
                }

                schedulePreview();
            });
        }
    });

    colorInputs.forEach((picker) => {
        picker.addEventListener('input', () => {
            syncInputColorFromPicker(picker);
            schedulePreview();
        });
    });

    sizeInputs.forEach((control) => {
        control.addEventListener('input', () => {
            syncInputSizeFromControl(control);
            schedulePreview();
        });
    });

    imageOptions.forEach((button) => {
        button.addEventListener('click', () => {
            imageInput.value = button.dataset.imageFile || '';
            syncSelectedImage();
            schedulePreview();
        });
    });

    imageInput.addEventListener('input', () => {
        syncSelectedImage();
        schedulePreview();
    });

    window.addEventListener('resize', resizeFrame);
    resizeFrame();
    colorInputs.forEach((picker) => syncColorPickerFromInput(document.getElementById(picker.dataset.styleColorFor || '')));
    sizeInputs.forEach((control) => syncSizeInputFromStyle(document.getElementById(control.dataset.styleSizeFor || '')));
    syncSelectedImage();
    schedulePreview();
})();
</script>
<?= $this->endSection() ?>

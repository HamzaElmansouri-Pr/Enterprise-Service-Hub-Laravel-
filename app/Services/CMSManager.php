<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\Section;
use stdClass;
use App\Services\CMSPageResolver;
use App\Services\CMSContentEditor;
use App\Services\CMSValidationRules;

class CMSManager
{
    protected CMSPageResolver $pageResolver;
    protected CMSContentEditor $contentEditor;
    protected CMSValidationRules $validationRules;

    public function __construct(CMSPageResolver $pageResolver, CMSContentEditor $contentEditor, CMSValidationRules $validationRules)
    {
        $this->pageResolver = $pageResolver;
        $this->contentEditor = $contentEditor;
        $this->validationRules = $validationRules;
    }

    // Delegated methods
    public function resolvePage(string $slug, array $fallbacks = [], bool $localize = false): stdClass
    {
        return $this->pageResolver->resolvePage($slug, $fallbacks, $localize);
    }

    public function getSection(string $type): Section
    {
        return $this->contentEditor->getSection($type);
    }

    public function getSectionContentBlocks(Section $section, bool $localize = false): array
    {
        return $this->contentEditor->getSectionContentBlocks($section, $localize);
    }

    public function updateSection(Section $section, array $validatedData, $request): void
    {
        $this->contentEditor->updateSection($section, $validatedData, $request);
    }

    public function updateSectionItem(Section $section, string $key, int $index, array $itemData, $request): array
    {
        return $this->contentEditor->updateSectionItem($section, $key, $index, $itemData, $request);
    }

    public function getValidationRules(string $type): array
    {
        return $this->validationRules->getRules($type);
    }

    public function parseType(string $type): array
    {
        // Delegating parsing logic to ContentEditor (or ValidationRules if needed)
        return $this->contentEditor->parseType($type);
    }

    public function getImageFields(string $type): array
    {
        return $this->validationRules->getImageFields($type);
    }
}
?>

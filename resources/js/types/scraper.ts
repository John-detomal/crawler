export type MatchConfigType = 'regex' | 'xpath' | 'css';
export type BrowserDriver = 'Curl' | 'Http' | 'Puppeteer';

type MatchConfig = {
    type: MatchConfigType;
    pattern: string;
    is_match_required?: boolean;
};

type ContentConfig = {
    container?: MatchConfig;
    items: MatchConfig;
};

type Field = {
    value: string;
    is_transform?: boolean;
    increment?: boolean;
    is_match_required?: boolean;
};

type Patterns = {
    pattern: string;
    type: MatchConfigType;
};

type FieldsConfig = Record<string, Field>;

type OptionsConfig = {
    fields: FieldsConfig;
    patterns: Patterns[];
};

export type Settings = {
    browser: BrowserDriver;
    base_url: string;
};

export type CategoryConfig = {
    content: ContentConfig;
    options: OptionsConfig;
};

type SubCategoryConfig = {
    extracts: ContentConfig[];
    options: OptionsConfig;
};

type IndexPageConfig = {
    extact: ContentConfig;
    options: OptionsConfig;
};

type PaginationConfig = {
    options: {
        url_format?: string;
        delimeter?: string;
        extract: ContentConfig;
        options: OptionsConfig;
        limit?: MatchConfig;
    };
};

export type ScraperConfig = {
    settings: Settings;
    category: CategoryConfig;
    sub_category: SubCategoryConfig;
    index_page: IndexPageConfig;
    pagination: PaginationConfig;
};

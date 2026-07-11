import InputSection from '@/components/atoms/configSection/input-section';
import Input from '@/components/atoms/input';
import Select from '@/components/atoms/select';
import { parserOptions } from '@/constants/parser-options';

type MatchConfigType = 'regex' | 'xpath' | 'css';

type ParserFieldProps = {
    type: MatchConfigType;
    pattern: string;
    onTypeChange: (value: MatchConfigType) => void;
    onPatternChange: (value: string) => void;
    className?: string;
};

export default function ParserField({
    type,
    pattern,
    onTypeChange,
    onPatternChange,
}: ParserFieldProps) {
    return (
        <InputSection>
            <Select
                className="col-span-3"
                data={parserOptions}
                value={type}
                onChange={(e) =>
                    onTypeChange(e.target.value as MatchConfigType)
                }
            />

            <Input
                className="col-span-9"
                value={pattern}
                onChange={(e) => onPatternChange(e.target.value)}
            />
        </InputSection>
    );
}

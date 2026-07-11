// text-text-main w-full rounded-lg border border-secondary/20 bg-background p-2 pl-7 font-mono text-xs transition-colors focus:border-primary focus:outline-none

import { cn } from '@/lib/utils';
export default function Input({
    className,
    type,
    ...props
}: React.ComponentProps<'input'>) {
    return (
        <input
            type={type}
            data-slot="input"
            className={cn(
                'text-text-main w-full rounded-lg border border-secondary/20 bg-background px-2 py-1 font-mono text-xs transition-colors focus:border-primary focus:outline-none',
                className,
            )}
            {...props}
        />
    );
}

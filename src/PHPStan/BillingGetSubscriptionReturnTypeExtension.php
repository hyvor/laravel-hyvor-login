<?php

namespace Hyvor\Internal\PHPStan;

use Hyvor\Internal\Billing\ActiveSubscription;
use Hyvor\Internal\Billing\Billing;
use Hyvor\Internal\InternalApi\ComponentType;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\Enum\EnumCaseObjectType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\UnionType;

class BillingGetSubscriptionReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{

    public function getClass(): string
    {
        return Billing::class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'getSubscriptionOfUser' ||
            $methodReflection->getName() === 'getSubscriptionOfResource';
    }

    public function getTypeFromStaticMethodCall(MethodReflection $methodReflection, StaticCall $methodCall, Scope $scope): ?\PHPStan\Type\Type
    {

        $arg = $methodCall->getArgs()[0]->value;
        $type = $scope->getType($arg);

        if (!$type instanceof EnumCaseObjectType) {
            return null;
        }

        $name = $type->getEnumCaseName();
        $componentType = ComponentType::tryFrom(strtolower($name));

        if ($componentType === null) {
            return null;
        }

        $featureBagClass = $componentType->featureBag();
        $plans = $componentType->plans();

        return new UnionType([
            new NullType(),
            new GenericObjectType(
                ActiveSubscription::class,
                [
                    new ObjectType($featureBagClass),
                    $plans ? new ObjectType($plans) : new NullType(),
                ]
            )
        ]);

    }
}